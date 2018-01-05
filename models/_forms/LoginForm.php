<?php

namespace app\models\_forms;

use Yii;
use app\models\User;
use app\models\Role;
use app\models\_abstracts\AuthForm;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends AuthForm
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function login(bool $isAdmin = false): bool
    {

        if ($this->validate()) {
            $user = $this->getUser();
            if ($isAdmin && (int) $user->roleId !== (int) Role::getRoleAdmin()) {
                $this->addError('email', Yii::t('app', 'You have no authority to access admin'));
                return false;
            }
            $duration = $this->rememberMe ? self::ONE_MONTH_IN_SECONDS : 0;
            return Yii::$app->user->login($user, $duration);
        }

        return false;
    }
}
