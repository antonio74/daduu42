<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "contact_category".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Contacts[] $contacts
 */
class Contact_category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['contact_category_id' => 'id']);
    }

     /**
     * @return an array with id and name of categories 
     */
    public static function getContact_category()
    {
        $queryCategory = Contact_category::find()->asArray()->all(); 
        $arrayCategory = ArrayHelper::map($queryCategory, 'id', 'name'); 
        return $arrayCategory;
    }

}
