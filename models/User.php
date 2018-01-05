<?php
/**
 * User class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use app\models\_queries\UserQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property integer $roleId
 * @property string  $password
 * @property string  $authKey
 * @property string  $accessToken
 * @property float   $name
 * @property float   $email
 * @property string  $phone
 * @property string  $address
 * @property-read Role
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var string
     */
    public $defaultRole = Role::ROLE_USER;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'roleId', 'password', 'name', 'email', 'phone', 'address'
            ], 'required'],
            [[
                'email', 'phone'
            ], 'unique'],
            [['authKey', 'accessToken'], 'string', 'max' => 32],
            [[
                'email'
            ], 'email'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common/labels', 'ID'),
        ];
    }

    public function saveData(): bool
    {
        $this->beforeSaveData();
        if ($this->save()) {
            return $this->afterSaveData();
        }
        return false;
    }

    public function beforeSaveData()
    {
        $this->roleId = Role::getRoleIdByName($this->defaultRole);
        $this->password = self::hashPassword($this->password);
    }

    public function afterSaveData(): bool
    {
        $user = self::findById($this->getPrimaryKey());
        Yii::$app->user->login($user);
        return true;
    }


    public static function find(): UserQuery
    {
        return new UserQuery(self::class);
    }

    /**
     * @return User | null
     */
    public static function findById(int $id)
    {
        return static::find()
            ->filterById($id)
            ->one();
    }

    /**
     * @return User | null
     */
    public static function findByEmail(string $email)
    {
       return static::find()
            ->filterByEmail($email)
            ->one();
    }

    /**
     * @param mixed $id The id.
     */
    public static function findIdentity($id): IdentityInterface
    {
        /* @var $id int */
        return self::findOne($id);
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public static function hashPassword(string $password): string
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword(string $password): bool
    {
        return self::validatePasswordHash($password, $this->password);
    }

    public static function validatePasswordHash(string $password, string $passwordHash): bool
    {
        return Yii::$app->security->validatePassword($password, $passwordHash);
    }

    public function getAuthKey(): string
    {
        return $this->authKey;
    }

    /**
     * @param mixed $authKey The auth key.
     */
    public function validateAuthKey($authKey): bool
    {
        /* @var $authKey string */
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $userType = null)
    {
        $user = self::find()
            ->where(["accessToken" => $token])
            ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
}
