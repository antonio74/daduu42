<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_to_contact_group".
 *
 * @property integer $id
 * @property integer $id_contatto
 * @property integer $id_gruppo
 *
 * @property Gruppo $idGruppo
 * @property Newrubrica $idContatto
 */
class Contact_to_contact_group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_to_contact_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_id', 'group_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contact_id' => Yii::t('app', 'Contact ID'),
            'group_id' => Yii::t('app', 'Group ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupId()
    {
        return $this->hasOne(Contact_group::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactId()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }
}
