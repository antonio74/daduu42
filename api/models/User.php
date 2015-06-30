<?php

namespace api\models;
use Yii;


class User extends \common\models\User 
{

	public function init() {
        //\Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;
        parent::init();        		

    }
}