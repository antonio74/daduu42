<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "user_group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Usersgroups[] $usersgroups
 */
class User_group extends TenantActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_group';
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
    public function getUsersgroups()
    {
        return $this->hasMany(User_to_user_group::className(), ['group_id' => 'id']);
    }


    public static function getGroups()
    {
        $queryGruppi = User_group::find()->asArray()->all(); 
        $arrayGruppi = ArrayHelper::map($queryGruppi, 'id', 'name');
        return $arrayGruppi;
    }
}
