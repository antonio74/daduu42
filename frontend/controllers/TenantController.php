<?php

namespace frontend\controllers;

use Yii;
use common\models\Tenant;
use common\models\User;
use common\models\TenantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\SignupForm;
use yii\filters\AccessControl;


/**
 * TenantController implements the CRUD actions for Tenant model.
 */
class TenantController extends Controller
{
    public function behaviors()
    {
        return [
        'access' => [        
            'class' => AccessControl::className(),
            'rules' => [        
                [
                'actions' => ['index', 'view', 'create', 'delete', 'update', 'createuser'],
                'allow' => User::isAdmin(),
                //'roles' => ['@'],
                ]
            ]
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
     * Creates a new User for current Tenant.
     * If creation is successful, the browser will be redirected to Tenant 'view' page.
     * @return mixed
     */
    public function actionCreateuser()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->actionView($model->tenant_id);
               
            }
        }

        return $this->render('createuser', [
            'model' => $model,
        ]);
    }



    /**
     * Lists all Tenant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TenantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tenant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tenant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tenant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            return $this->redirect(['index', 'm' => 1]);  // or redirect to index
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tenant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tenant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tenant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tenant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tenant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
