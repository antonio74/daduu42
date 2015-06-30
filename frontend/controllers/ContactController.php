<?php

namespace frontend\controllers;

use Yii;
use common\models\Contact_category;
use common\models\Contact;
use common\models\ContactSearch;
use common\models\Contact_to_contact_group;
use common\models\Contact_group;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\HttpException;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
{
    public function behaviors()
    {
        return [
        'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
    
                    [
                        'actions' => ['logout', 'index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['update', 'delete', 'create', 'create-group-or-category'],
                        'allow' => true,
                        'roles' => ['@'],
                        //'matchCallback' => User::isAdmin()
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $categorie = Contact_category::getContact_category();   
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 'categorie' => $categorie
        ]);
    }

    /**
     * Displays a single Contact model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id), 
        ]);
    }



    public function actionCreateGroupOrCategory($errorCode)
    {
        return $this->render('createGroupOrCategory', [
            'errorCode' => $errorCode
        ]);
    }

    /**
     * Creates a new Contact model.
     * If no group or category exist will redirect to related creation page.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contact();
        $errorCode = 0;
        $categorie = Contact_category::getContact_category(); 
        if($categorie == null)
            $errorCode = 1;
        $gruppi = Contact_group::getGruppi();
        if($gruppi == null)
            $errorCode = $errorCode + 2;
        if($errorCode > 0)
            return $this->redirect(['create-group-or-category', 'errorCode' => $errorCode]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            /* passage of parameter $categorie to 'create' view, and then to '_form' partial */
            return $this->render('create', [
                'model' => $model, 'categorie' => $categorie
            ]);
        }
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);        
        $categorie = Contact_category::getContact_category();   

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //$model->gruppi = $model->getGruppiContattis()->select('id_gruppo')->column(); //$model->getCheckedGroups();
            return $this->render('update', [
                'model' => $model, 'categorie' => $categorie,
            ]);
        }
    }

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }



    public function beforeAction($action)
    {
        $parentAllowed = parent::beforeAction($action);
        if($action->id == 'update' || $action->id == 'delete')
        {
            $model = $this->findModel($_GET['id']);        
            if(!User::isAllowed($model))
                throw new HttpException(403, "You don't have request privileges to $action->id this contact.");
        }
        return $parentAllowed;

    }


    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
