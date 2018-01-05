<?php
/**
 * TransactionQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\Transaction;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Transaction]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see Transaction
 */
class TransactionQuery extends ActiveQuery
{
    public function filterById(int $id): TransactionQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param int[] $orderIds
     */
    public function hasOrderIds(array $orderIds): TransactionQuery
    {
        return $this->andWhere(['orderId' => $orderIds]);
    }
}
