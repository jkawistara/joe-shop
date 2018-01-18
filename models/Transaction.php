<?php
/**
 * Transaction class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\_queries\TransactionQuery;

/**
 * This is the model class for table "Transaction".
 *
 * @property integer $id
 * @property integer $orderId
 * @property integer $transactionId
 */
class Transaction extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Transactions';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'orderId', 'transactionId'
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

    public static function find(): TransactionQuery
    {
        return new TransactionQuery(self::class);
    }

    /**
     * @return string[]
     */
    public static function findAllTransaction(int $limit = null): array
    {
        $q = static::find();

        if(!empty($limit)){
            $q->limit($limit);
        }

        return $q->all();
    }

    public static function saveTransaction(int $transactionId, int $orderId)
    {
        $transaction = new Transaction();
        $transaction->transactionId = $transactionId;
        $transaction->orderId = $orderId;
        $transaction->save();
    }
}
