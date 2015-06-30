<?php
namespace frontend\models;

use common\models\User;
use common\models\User_to_user_group;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $tenant_id;
    public $groups;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['tenant_id', 'safe'],
            ['groups', 'safe'],            
        ];
    }

    /**
     * Signs user up and store it in related tenant if is setted up or '1' by default.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            if($this->tenant_id != null)
                $user->tenant_id = $this->tenant_id;            
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            $group = new User_to_user_group();
            $group->user_id = $user->id;
            $group->user_group_id = $this->groups;
            $group->save();
            return $user;
        }

        return null;
    }
}
