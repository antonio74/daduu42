<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "Contact".
 *
 * @property integer $id
 * @property string $cognome
 * @property string $nome
 * @property string $mobile
 * @property string $email
 * @property integer $id_categoria
 *
 * @property Gruppicontatti[] $gruppicontattis
 * @property Categoria $idCategoria
 */
class Contact extends TenantActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    // Array of group's ids to which contact belong
    public $gruppi = array();


    /* Utile per la parte API perchè quando è impostato il parametro GET expand=contact_category 
     * elimina il campo ridondante contact_category_id */
    public function fields()
    {
        $fields = parent::fields();
        if(isset($_GET['expand'])){
            $param=explode(',', $_GET['expand']);
            foreach ($param as $key => $field)
                if(trim($field) == 'contact_category')
                    unset($fields['contact_category_id']);
        }   
        return $fields;
    }


    /**
     * @inheritdoc
     */    
    public function afterFind()
    {
        //$newrubricas=$this->find()->where(['nome'=>'Antonio']);
        $this->gruppi = $this->getContact_to_contact_groups()->select('contact_group_id')->column();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'company' , 'phone_prefix', 'phone', 'mobile_prefix', 'mobile', 'general_prefix', 'general' ], 'required'],
            [['contact_category_id'], 'integer'],
            [['gruppi'], 'safe'],
            [['firstname', 'lastname', 'mobile', 'email'], 'string', 'max' => 255],
            [['email'], 'unique', 'targetClass' => '\common\models\Contact', 'message' => 'This email address has already been taken.'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'company' => Yii::t('app', 'Company'),
            'email' => Yii::t('app', 'Email'),
            'phone_prefix' => Yii::t('app', 'Phone prefix'),
            'phone' => Yii::t('app', 'Phone'),
            'mobile_prefix' => Yii::t('app', 'Mobile prefix'),
            'mobile' => Yii::t('app', 'Mobile'),
            'general_prefix' => Yii::t('app', 'General prefix'),
            'general' => Yii::t('app', 'General'),
            'contact_category_id' => Yii::t('app', 'Category'),
        ];
    }

    

    /**
     *
     * @return ActiveQuery - Questa funzione  rappresenta una relazione  che restituisce i dettagli del 
     *                       gruppo relativo ad un contatto attraverso la tabella pivot gruppicontatti.
     */
    public function getContact_groups()
    {
        return $this->hasMany(Contact_group::className(), ['id' => 'contact_group_id'])->via('contact_to_contact_groups');
    }

    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact_to_contact_groups()
    {
        return $this->hasMany(Contact_to_contact_group::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact_category()
    {
        return $this->hasOne(Contact_category::className(), ['id' => 'contact_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::className(), ['id' => 'tenant_id']);
    }

    /*
    * 
    */
    public function afterSave($insert, $changedAttributes)
    {
        $connection = \Yii::$app->db;
        $queryTuttiGruppi = $this->getContact_groups()->asArray()->all();
        $arrayTuttiGruppi = ArrayHelper::map($queryTuttiGruppi, 'id', 'name');        
        // if not a new contact, delete all groups 
        if(!$insert){
            Contact_to_contact_group::deleteAll('contact_id = :id', [ ':id' => $this->id ]);
        }

        $gruppiSelezionati = $this->gruppi;
        $gruppiScrittura = Contact_group::getGruppi();
        // aggiunge i gruppi di cui fa parte il contatto e che non ho il permesso di modificare 
        foreach ($arrayTuttiGruppi as $key => $value) {
            if(!array_key_exists($key, $gruppiScrittura))
                array_push($gruppiSelezionati, $key);
        }
        $lenght = count($gruppiSelezionati);       
        $contatti = array_fill(0, $lenght, $this->id);
        $gruppicontatti= array_map(null, $contatti, $gruppiSelezionati);
        $connection->createCommand()->batchInsert('contact_to_contact_group', ['contact_id', 'contact_group_id'], $gruppicontatti )->execute();

    }



    public function stringaGruppi()
    {
        $nomiGruppi = Contact_group::getAllGruppi();
        $gruppi = "";
        foreach ($this->gruppi as $key => $idGruppo) {
            if ($gruppi!==""){
                $gruppi = $gruppi.", ";
            }
            if(array_key_exists($idGruppo, $nomiGruppi))
                $gruppi = $gruppi.$nomiGruppi[$idGruppo];
        }
        return $gruppi;
    }




    /************************************ Eliminata: Trovata soluzione utilizzando getGruppiContattis
    public function getCheckedGroups(){
        $connection = \Yii::$app->db;
        $id = $this->id;
        $sql = $connection->createCommand("SELECT id_gruppo FROM gruppicontatti WHERE id_contatto = $id")->queryColumn();
        return $sql;

    }
    */

}
