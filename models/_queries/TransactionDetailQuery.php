<?php
/**
 * TransactionDetailQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\TransactionDetail;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[TransactionDetail]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see TransactionDetail
 */
class TransactionDetailQuery extends ActiveQuery
{
    public function filterById(int $id): TransactionDetailQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function hasPaymentReceipt(): TransactionDetailQuery
    {
        return $this->andWhere(['not', ['paymentReceipt' => NULL]]);
    }

    /**
     * @param int[] $transactionIds
     */
    public function hasTransactionIds(array $transactionIds): TransactionDetailQuery
    {
        return $this->andWhere(['id' => $transactionIds]);
    }

    public function orderByNewestId(): ActiveQuery
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }
}
