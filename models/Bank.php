<?php
/**
 * Bank class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\_queries\BankQuery;

/**
 * This is the model class for table "Bank".
 *
 * @property integer $id
 * @property string $accountName
 * @property string $accountNumber
 */
class Bank extends ActiveRecord
{

    const DEFAULT_ACCOUNT_NUMBER = '1111-111-111-2';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Banks';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'accountName', 'accountNumber'
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

    public static function find(): BankQuery
    {
        return new BankQuery(self::class);
    }

    /**
     * @return string[]
     */
    public static function findAllBank(int $limit = null): array
    {
        $q = static::find();

        if(!empty($limit)){
            $q->limit($limit);
        }

        return $q->all();
    }

    public static function findByAccountNumber(string $number): Bank
    {
        return static::find()
            ->filterByAccountNumber($number)
            ->one();
    }
}
