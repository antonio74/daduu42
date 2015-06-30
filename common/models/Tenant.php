<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\User_group;
use common\models\User_to_user_group;
use yii\web\NotFoundHttpException;


/**
 * This is the model class for table "tenant".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Categoria[] $categorias
 * @property Gruppo[] $gruppos
 * @property Newrubrica[] $newrubricas
 * @property User[] $users
 */
class Tenant extends TenantActiveRecord
{


    public $tenantUsers = array();
    public $username = '';
    public $autologin = false;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tenant';
    }


    /**
     * @inheritdoc
     */    
    public function afterFind()
    {
        //$newrubricas=$this->find()->where(['name'=>'Antonio']);
        $this->tenantUsers = $this->getUsers()->select('id')->column();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['tenantUsers'], 'safe'],
            [['username'], 'validateUser']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact_categories()
    {
        return $this->hasMany(Contact_category::className(), ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact_groups()
    {
        return $this->hasMany(Contact_group::className(), ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['tenant_id' => 'id']);
    }


    /**
     * Generate the first user when create a tenant
     * @return 
     */
    public function afterSave($insert, $changedAttributes)
    {
        $connection = \Yii::$app->db;
        $tenantUsers = $this->tenantUsers;
        $user = User::findByUsername($this->username);
        if(!$user){
            // Creazione primo utente del tenant
            $user = new User();
            $user->username = $this->username;
            $user->email = 'admin@daduu.dev';
            $user->tenant_id = $this->id;
            $user->setPassword('admin');
            $user->generateAuthKey();
            $user->save();

            // Creazione gruppo Administrator
            $userGroup = new User_group;
            $userGroup->name = 'Administrator';
            $userGroup->changeTenant = true;
            $userGroup->tenant_id = $user->tenant_id;
            $userGroup->save();

            // Inserimento del primo utente nel gruppo Administrator del tenant
            $user_to_user_group = new User_to_user_group;
            $user_to_user_group->user_id = $user->id;
            $user_to_user_group->user_group_id = $userGroup->id;
            $user_to_user_group->save();

            // Creazione gruppo Standard
            $userGroup = new User_group;
            $userGroup->name = 'Standard';
            $userGroup->changeTenant = true;
            $userGroup->tenant_id = $user->tenant_id;
            $userGroup->save();
            

            if($this->autologin == true)
                Yii::$app->user->login($user);
            else {
                // Invio email con username e password
                $to      = \Yii::$app->user->identity->email;
                $subject = 'daduu registration';
                $message = 'Hello from daduu. User registration is successful!!!' . "\r\n" .
                           'username: ' . $user->username . '   password: admin';
                $headers = 'From: daduu42@localhost.it' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

                $m=mail($to, $subject, $message, $headers);

                if(!$m)
                    throw new NotFoundHttpException('Non è stato possibile inviare l\'email con le credenziali di registrazione!');
            }
        }  
        elseif($this->autologin == true){
            if($user->tenant_id!=$this->id)           
                throw new NotFoundHttpException('ATTENZIONE! L\'utente fa parte di un altro tenant!');     
            else Yii::$app->user->login($user);
   
        }
    }


    /** 
     * Generate the usernames string of current tenant
     */
    public function usernamesToString()
    {
        $users = User::getUsers();
        $usernames = "";
        foreach ($this->tenantUsers as $key => $idUser) {
            if ($usernames !== ""){
                $usernames = $usernames.", ";
            }
            $usernames = $usernames.$users[$idUser];
        }
        return $usernames;
    }

    public function userTenant()
    {
        return (in_array(Yii::$app->user->id, $this->tenantUsers));
    }


    /**
     * Valida username verificando che non sia già presente in User
     *
     */
    public function validateUser($attribute, $params)
    {
        if (User::findByUsername($this->username) && $this->autologin == false) {
            $this->addError($attribute, 'This username already exist!!!');
        }
    }
}
