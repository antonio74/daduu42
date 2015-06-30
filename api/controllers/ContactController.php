<?php

namespace api\controllers;

use yii;
use yii\rest\ActiveController;
use yii\rest\Controller;
use api\models\ContactSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

class ContactController extends ActiveController
{
  public $modelClass = 'api\models\Contact';


  public function actions()
  {
    $actions = parent::actions();
    // personalizza il data provider preparation con il metodo "prepareDataProvider()"
    $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

    return $actions;
  }

  /**
   * Prepara e restituisce un data provider per la action index utilizzando Newrubricasearch per filtrare e 
   * ordinare le tuple di contatti attraverso più attributi. Per filtrare e ordinare per categoria e gruppo
   * deve essere impostato anche il rispettivo valore del parametro expand.
   * Esempio: http://host?filter={"attributo1":"valore1", "attributo2":"valore2"}&sort=attributo1,-attributo2
   * @return ActiveDataProvider  
   */
  public function prepareDataProvider()
  {
    $params=$_REQUEST;
    $filter=array();
    $expand='';
    $sort='';
    // $page=1; $limit=10;  $offset=$limit*($page-1);
 
 
    // Filter elements 
    if(isset($params['filter']))
      $filter=array_filter((array)json_decode($params['filter']), 'trim');   


    if(isset($params['expand']))
      $expand=$params['expand'];
    
    // Sort elements 
    if(isset($params['sort']))
        $sort=array_filter((array)json_decode($params['sort']), 'trim');


    $searchModel = new ContactSearch();
    $dataProvider = $searchModel->search(['ContactSearch'=>$filter, 'expand'=>$expand, 'sort' =>$sort]);
    $this->setHeader(200);
    return $dataProvider;

    //return array('status'=>1,'data'=>$dataProvider,'totalItems'=>'1');
 
  }


  /* Functions to set header with status code. eg: 200 OK ,400 Bad Request etc..*/      
  private function setHeader($status)
  {
 
    $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
    $content_type="application/json; charset=utf-8";
 
    header($status_header);
    header('Content-type: ' . $content_type);
    header('X-Powered-By: ' . "Antonio Chiriaco'");
  }

  private function _getStatusCodeMessage($status)
  {
    $codes = Array(
    200 => 'OK',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    );
    return (isset($codes[$status])) ? $codes[$status] : '';
  }

}