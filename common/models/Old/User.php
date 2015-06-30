<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\backend\controllers\NewrubricaController;
use yii\web\HttpException;




/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;   

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public function afterFind()
    {
        Yii::$app->session['tenant'] = $this->tenant_id;
        Yii::$app->session['group'] = $this->getGruppo()->select('name')->column();        

    }


    /**
     * @return array of group's names
     */    
    public static function getUsers()
    {
        $queryUsers = User::find()->asArray()->all(); 
        $arrayUsers = ArrayHelper::map($queryUsers, 'id', 'username');
        return $arrayUsers;
    }


    public function getGruppo()
    {
        return $this->hasMany(User_group::className(), ['id' => 'group_id'])->via('user_to_user_group');
    }


    public function getUsergroups()
    {
        return $this->hasMany(Usersgroups::className(), ['id_user' => 'id']);
    }


    public static function isAdmin() 
    {
        return (Yii::$app->session['group'][0] == 'admin');
    }

    /*
     * Controlla se l'utente ha il permesso in scrittura su un singolo record
     *
     */
    public static function isAllowed($model) 
    {   
        if(array_pop(explode("\\", get_class($model)))=='Newrubrica')
            $permessi = $model->getGruppis()->select(['visibilita', 'autorizzati', 'permessi'])->asArray()->all();
        else {
                $permessi[0]['permessi']=$model->permessi;
                $permessi[0]['autorizzati']=$model->autorizzati;
                $permessi[0]['visibilita']=$model->visibilita;                
        }
    
        foreach ($permessi as $key) {      
            if( ($key['permessi'] == 'RW' ||  ltrim($key['permessi'], 'RW') == Yii::$app->user->id) && 
                (($key['visibilita'] == 'gruppo' && $key['autorizzati'] == Yii::$app->session['group'][0]) ||
                 ($key['visibilita'] == 'tenant' && $key['autorizzati'] == Yii::$app->session['tenant']) ||
                 ($key['visibilita'] == 'privato' && $key['autorizzati'] == Yii::$app->user->id)))
            return true;
        }
        return false;
    }

    // Filtra applicando i criteri per i permessi in lettura
    public static function readFilter($model)
    {
        return $model->andFilterWhere(['or',  ['visibilita' => 'gruppo', 'gruppo.autorizzati' => Yii::$app->session['group'][0]],
                                                ['visibilita' => 'privato', 'gruppo.autorizzati' => Yii::$app->user->id],
                                                ['visibilita' => 'tenant', 'gruppo.autorizzati' => Yii::$app->session['tenant']]]);
    }
}
