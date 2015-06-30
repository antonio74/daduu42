<?php

namespace api\controllers;

use yii;
use yii\rest\ActiveController;
use \common\model\User;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\auth\QueryParamAuth;


class UserController extends ActiveController
{
	public $modelClass = 'api\models\User';

	/*
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = ['class' => QueryParamAuth::className(),];
		return $behaviors;
	}
	*/
  

}