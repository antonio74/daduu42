<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $visibility
 * @property string $permissions
 * @property string $read_write
 *
 * @property ContactToContactGroup[] $contactToContactGroups
 * @property Contact[] $contacts
 */
class ContactGroup extends \common\models\TenantActiveRecord
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
            [['name', 'visibility', 'permissions', 'read_write'], 'required'],
            [['name', 'visibility', 'permissions', 'read_write'], 'string', 'max' => 255]
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
            'visibility' => Yii::t('app', 'Visibility'),
            'permissions' => Yii::t('app', 'Permissions'),
            'read_write' => Yii::t('app', 'Read Write'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactToContactGroups()
    {
        return $this->hasMany(ContactToContactGroup::className(), ['contact_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['id' => 'contact_id'])->viaTable('contact_to_contact_group', ['contact_group_id' => 'id']);
    }
}
