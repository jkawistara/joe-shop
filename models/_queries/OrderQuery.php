<?php
/**
 * OrderQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\Order;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Order]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see Order
 */
class OrderQuery extends ActiveQuery
{
    public function filterById(int $id): OrderQuery
    {
        return $this->andWhere(['id' => $id]);
    }
    public function filterByUserId(int $userId): OrderQuery
    {
        return $this->andWhere(['userId' => $userId]);
    }

}
