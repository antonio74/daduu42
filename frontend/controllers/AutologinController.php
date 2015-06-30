<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Tenant;
use common\models\Contact_category;
use common\models\User;
use common\models\User_group;
use common\models\User_to_user_group;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;


/**
 * Site controller
 */
class AutologinController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $params=$_REQUEST;
        $tenantName='';
        $tenant=new Tenant();
        $username='';
        $user='';
        if (isset($params['username']) && isset($params['tenantName'])  && isset($params['token']))
        {
            $username=$params['username'];
            $user=User::findByUsername($username); //User::find()->where(['username' => $username]);
            $tenantName=$params['tenantName'];
            $tenant=Tenant::find()->where(['name' => $tenantName]);
            $token = $params['token'];
            $code = "fromblakpearl4todaduubyantoniochiriaco";
            $decoded_parameters = $username.$tenantName.$code;
            //$encoded_parameters = crypt($decoded_parameters, '$2y$15$R.gJb2U2N.FmZ4hPp1y2CN$'); //'$6$sawhmo1pMjf7$');
            //echo $token;
            //echo "    ";
            //echo $encoded_parameters;
            //exit;
            if(crypt($decoded_parameters, $token) != $token) //($token != $encoded_parameters)
                throw new NotFoundHttpException('Le credenziali d\'accesso non sono corrette!');

            if($tenant->exists() && $user!=null){
                if ($tenant->scalar() != $user->tenant_id)
                    throw new NotFoundHttpException('Le credenziali d\'accesso non sono corrette!');
                else
                {
                    Yii::$app->user->login($user);
                    return $this->goHome();
                }
            }
            

            if(!($tenant->exists())){
                $tenant = new Tenant();
                $tenant->autologin = true;
                $tenant->name = $tenantName;
                $tenant->username = $username;
                $tenant->save();
                //$tenant = Tenant::find()->where(['name' => $tenantName]);
            }
            else if($user==null)
            {
                $user = new User();
                $user->username = $username;
                $user->email = 'admin@daduu.dev';
                $user->tenant_id = $tenant->scalar();
                $user->setPassword('admin');
                $user->generateAuthKey();
                $user->save();

                // Inserimento dell'utente neli'ultimo gruppo del tenant
                /*$group = User_group::find()->orderBy('id desc')->one();                
                $user_to_user_group = new User_to_user_group();
                $user_to_user_group->user_id = $user->id;
                $user_to_user_group->user_group_id = $group['id'];
                $user_to_user_group->save();
                */

                $group = User_group::find()->where(['name' => 'Standard', 'tenant_id' => $user->tenant_id])->one(); 
                $user_to_user_group = new User_to_user_group();
                $user_to_user_group->user_id = $user->id;
                $user_to_user_group->user_group_id = $group['id'];
                $user_to_user_group->save();
                

                Yii::$app->user->login($user);
                return $this->goHome();
            }
            return $this->goHome();            
        }
        else throw new NotFoundHttpException('Le credenziali d\'accesso non sono corrette!');
/*
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }*/
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
