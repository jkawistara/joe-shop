<?php
/**
 * Register form class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_forms;

use Yii;
use app\models\User;
use app\models\Role;
use app\models\_abstracts\AuthForm;

/**
 * RegisterForm is the model behind the register form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends AuthForm
{
    const ONE_MONTH_IN_SECONDS = 3600*24*30;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $phone;

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
            [['email', 'password', 'name', 'address', 'phone'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function login(): bool
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $duration = $this->rememberMe ? self::ONE_MONTH_IN_SECONDS : 0;
            return Yii::$app->user->login($user, $duration);
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function saveData()
    {
        $user = new User();
        $user->setAttributes($this->getAttributes());
        $user->roleId = $user->defaultRole;
        if (!$user->validate()) {
            $this->addError('email',$user->getFirstError('email'));
            return false;
        }
        $user->beforeSaveData();
        if ($user->save()) {
            return $user->afterSaveData();
        }
        return false;
    }
}
