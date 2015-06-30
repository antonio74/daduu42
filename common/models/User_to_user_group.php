<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "User_to_user_group".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_group
 *
 * @property Groups $idGroup
 * @property User $idUser
 */
class User_to_user_group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_to_user_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_group_id'], 'required'],
            [['user_id', 'user_group_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_group_id' => Yii::t('app', 'User Group ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupId()
    {
        return $this->hasOne(User_group::className(), ['id' => 'user_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
