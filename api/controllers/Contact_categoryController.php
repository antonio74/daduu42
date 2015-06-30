<?php

namespace api\controllers;

use yii;
use yii\rest\ActiveController;
use \common\model\Contact_category;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

class Contact_categoryController extends ActiveController
{
  public $modelClass = 'api\models\Contact_category';


}