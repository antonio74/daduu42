<?php
 
namespace common\models;

use Yii;
use common\models\User;
use common\models\Tenant;


class TenantActiveRecord extends \yii\db\ActiveRecord
{
 
    public $changeTenant = false;

    public function rules()
    {
        $rules = parent::rules();
        $rules[]= [['changeTenant'], 'safe'];
        return $rules;
    }

    //saving model->id_tenant to all tables automatic
    public function beforeSave($insert)
    {
        $field = '';
        $tenantTableName = '{{%tenant}}';        
        if(parent::tableName() != $tenantTableName && !$this->changeTenant)
        {
            $tenant = $this->getTenant();
            $this->tenant_id = Yii::$app->session['tenant'];
        }
        return parent::beforeSave($insert);
    }
 
    /*  Filtro per tenant di competenza dell'utente
     */
	public static function find()
	{
        $tenantTableName = '{{%tenant}}';
        $field = '';
    	$model = parent::find();
        if(parent::tableName() == $tenantTableName)
            $field = '.id';
        else $field = '.tenant_id';
        $model->where([ parent::tableName() . $field => Yii::$app->session['tenant'] ]);
        return $model;
	}


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $tenant = $this->getTenant();
            if ($this->tenant_id == Yii::$app->session['tenant'])
                return true;
        }
        return false;
    }

 	public function getTenant()
 	{
 		return Yii::$app->session['tenant'];
 	}

 }