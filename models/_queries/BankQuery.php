<?php
/**
 * BankQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\Bank;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Bank]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see Bank
 */
class BankQuery extends ActiveQuery
{
    public function filterById(int $id): BankQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function filterByAccountNumber(string $number): BankQuery
    {
        return $this->andWhere(['accountNumber' => $number]);
    }
}
