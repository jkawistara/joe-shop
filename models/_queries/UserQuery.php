<?php
/**
 * UserQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[User]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see User
 */
class UserQuery extends ActiveQuery
{
    public function filterById(int $id): UserQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function filterByRoleId(int $roleId): UserQuery
    {
        return $this->andWhere(['roleId' => $roleId]);
    }

    public function filterByName(string $name): UserQuery
    {
        return $this->andWhere(['like', 'name', $name]);
    }

    public function filterByPhone(string $phone): UserQuery
    {
        return $this->andWhere(['like', 'phone', $phone]);
    }

    public function filterByAddress(string $address): UserQuery
    {
        return $this->andWhere(['like', 'address', $address]);
    }

    public function filterByEmail(string $email): UserQuery
    {
        return $this->andWhere(['email' => $email]);
    }
}
