<?php
/**
 * RoleQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\Role;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Role]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see Role
 */
class RoleQuery extends ActiveQuery
{
    public function filterById(int $id): RoleQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function filterByType(int $type): RoleQuery
    {
        return $this->andWhere(['type' => $type]);
    }

    public function filterByRoleName(string $roleName): RoleQuery
    {
        return $this->andWhere(['description' => strtolower($roleName)]);
    }
}
