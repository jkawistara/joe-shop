<?php
/**
 * Role class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\_queries\RoleQuery;

/**
 * This is the model class for table "Role".
 *
 * @property integer $id
 * @property integer $type
 * @property string  $description
 *
 */
class Role extends ActiveRecord
{

    const ROLE_ADMIN = 'admin';

    const ROLE_USER = 'member';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Roles';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'type', 'description'
            ], 'required'],
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

    public static function find(): RoleQuery
    {
        return new RoleQuery(self::class);
    }

    public static function findById(int $id): Role
    {
        return static::find()
            ->filterById($id)
            ->one();
    }

    public static function getRoleIdByName(string $roleName): int
    {
        return static::find()
            ->select('id')
            ->filterByRoleName($roleName)
            ->scalar();
    }

    public static function getRoleUser(): int
    {
        return static::getRoleIdByName(self::ROLE_USER);
    }

    public static function getRoleAdmin(): int
    {
        return static::getRoleIdByName(self::ROLE_ADMIN);
    }

    /**
     * @return string[]
     */
    public static function getRole(): array
    {
        return [
            'admin' => static::getRoleIdByName(self::ROLE_ADMIN),
            'user' => static::getRoleIdByName(self::ROLE_USER)
        ];
    }

    public static function isUser(): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $userRoleId = self::getRoleUser();
        return Yii::$app->user->identity->roleId === $userRoleId ? true : false;
    }

    public static function isAdmin(): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $adminRoleId = self::getRoleAdmin();
        return Yii::$app->user->identity->roleId === $adminRoleId ? true : false;
    }
}
