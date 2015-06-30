<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "contact_group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Contact_to_Contact_group[] $contact_to_Contact_group
 */
class Contact_group extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['visibility', 'permissions', 'read_write'], 'string'],
            [['name'], 'string', 'max' => 255]
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
    public function getContact_groups()
    {
        return $this->hasMany(Contact_to_contact_group::className(), ['group_id' => 'id']);
    }


    /**
     * @return array of group's names
     */    
    public static function getGruppi()
    {
        $queryGruppi = Contact_group::find()->andWhere(['or', ['read_write' => 'RW'], ['read_write' => 'RW'.Yii::$app->user->id]])
                                        ->andWhere(['or', ['visibility' => 'privato', 'permissions' => Yii::$app->user->id],
                                                          ['visibility' => 'gruppo', 'permissions' => Yii::$app->session['group'][0]],
                                                          ['visibility' => 'tenant', 'permissions' => Yii::$app->session['tenant']]])
                                        ->asArray()->all(); 
        $arrayGruppi = ArrayHelper::map($queryGruppi, 'id', 'name');
        return $arrayGruppi;
    }


    //saving model->id_tenant to all tables automatic
    public function beforeSave($insert)
    {
        if($this->visibility == 'gruppo')
            $this->permissions = Yii::$app->session['group'][0];
         elseif($this->visibility == 'privato')
             $this->permissions = Yii::$app->user->id;
          elseif($this->visibility == 'tenant')
              $this->permissions = Yii::$app->session['tenant'];
        return parent::beforeSave($insert);
    }    



    public static function getAllGruppi()
    {
        $queryGruppi = Contact_group::find()->andWhere(['or', ['visibility' => 'privato', 'permissions' => Yii::$app->user->id],
                                                          ['visibility' => 'gruppo', 'permissions' => Yii::$app->session['group'][0]],
                                                          ['visibility' => 'tenant', 'permissions' => Yii::$app->session['tenant']]])
                                    ->asArray()->all(); 
        $arrayGruppi = ArrayHelper::map($queryGruppi, 'id', 'name');
        return $arrayGruppi;
    }

}
