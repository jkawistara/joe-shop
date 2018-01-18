<?php
/**
 * TransactionDetail class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\_queries\TransactionDetailQuery;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "TransactionDetail".
 *
 * @property integer $id
 * @property integer $bankId
 * @property integer $couponId
 * @property integer $status
 * @property float   $totalPrice
 * @property float   $totalPayment
 * @property string  $transactionDate
 * @property string  $paymentDate
 * @property string  $shippingId
 * @property int     $courierId
 * @property string  $paymentReceipt
 */
class TransactionDetail extends ActiveRecord
{
    const STATUS_NOT_PAID = 0;

    const STATUS_PAID = 1;

    const STATUS_REFUNDED = 2;

    const STATUS_CANCEL = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TransactionDetails';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'bankId', 'status', 'totalPrice', 'totalPayment', 'transactionDate'
            ], 'required'],
            [[
                'couponId', 'paymentDate', 'paymentReceipt', 'shippingId', 'courierId'
            ], 'safe'],
            [[
                'paymentReceipt'
            ], 'file', 'extensions' => 'png, jpg'],
            [[
                'totalPrice', 'totalPayment',
            ], 'number'],
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

    public static function find(): TransactionDetailQuery
    {
        return new TransactionDetailQuery(self::class);
    }

    /**
     * @return null|string
     */
    public function getCouponIdLabel()
    {
        if (empty($this->couponId)) {
            return null;
        }

        return Coupon::find()
            ->select('couponCode')
            ->filterById($this->couponId)
            ->scalar();
    }

    /**
     * @return null|string
     */
    public function getBankIdLabel()
    {
        if (empty($this->bankId)) {
            return null;
        }

        return Bank::find()
            ->select('accountName')
            ->filterById($this->bankId)
            ->scalar();
    }

    /**
     * @return null|string
     */
    public function getCourierLabel()
    {
        if (empty($this->courierId)) {
            return null;
        }

        return Courier::find()
            ->select('name')
            ->filterById($this->courierId)
            ->scalar();
    }

    /**
     * @return string[]
     */
    public static function getCourierLabels(): array
    {
        $couriers = [];
        array_map(function($courier) use (&$couriers) {
            $couriers[$courier->id] = $courier->name;
        }, Courier::findAllCourier()) ;

        return $couriers;
    }

    /**
     * @return array
     */
    public static function getArrayStatusLabels(): array
    {
        return [
            self::STATUS_NOT_PAID => 'Not Paid',
            self::STATUS_PAID => 'Paid',
            self::STATUS_REFUNDED => 'Refunded',
            self::STATUS_CANCEL => 'Cancelled'
        ];
    }

    /**
     * @return null|string
     */
    public function getStatusLabel()
    {
        return self::getArrayStatusLabels()[$this->status];
    }

    /**
     * @return string[]
     */
    public static function findAllTransactionDetail(int $limit = null): array
    {
        $q = static::find();

        if(!empty($limit)){
            $q->limit($limit);
        }

        return $q->all();
    }

    public static function saveTransactionDetail(): int
    {
        $detail = Yii::$app->session->get('payment');
        $transaction = new TransactionDetail();
        $transaction->bankId = $detail->bankId;
        if(!empty($detail->couponId)) {
            $transaction->couponId = $detail->couponId;
            Coupon::reduceQtyById($detail->couponId);
        }
        $transaction->status = $detail->status;
        $transaction->totalPrice = $detail->totalPrice;
        $transaction->totalPayment = !empty($detail->totalPayment) ? $detail->totalPayment : $detail->totalPrice;
        $transaction->transactionDate = $detail->transactionDate;
        $transaction->save();

        Yii::$app->session->remove('payment');
        return $transaction->id;
    }

    public function calculatePayment(Coupon $coupon)
    {
        if ($coupon->type === Coupon::TYPE_COUPON_PERCENTAGE) {
            $this->totalPayment = $this->totalPrice - ($this->totalPrice * $coupon->value / 100);
        } else if ($coupon->type === Coupon::TYPE_COUPON_PRICE) {
            $this->totalPayment = $this->totalPrice - $coupon->value;
        }
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

    public function uploadTransactionProof(int $id): bool
    {
        $this->paymentReceipt = UploadedFile::getInstance($this, 'paymentReceipt');
        $this->paymentReceipt = $this->upload($id);
        $this->paymentDate = date('Y-m-d');
        $this->save(false);
        return true;
    }

    public function upload(int $id): string
    {
        $file = $this->paymentReceipt;
        /** @var \frostealth\yii2\aws\s3\Service $s3 */
        $s3 = Yii::$app->get('s3');
        $identity = rand(1,1000);
        $keyname = 'transaction/proof-transaction-' . $id. '-' .$identity. '.' . $file->extension;
        $result = $s3->upload($keyname, $file->tempName);
        return $result['ObjectURL'];
    }

    /**
     * @return int[]
     */
    public static function getTransactionsIds(): array
    {
        $userId = Yii::$app->user->identity->getId();
        $orderIds = self::getOrderIds($userId);
        $transactions = Transaction::find()->hasOrderIds($orderIds)->all();
        return array_map(function($transaction){
            return $transaction->transactionId;
        }, $transactions);
    }

    /**
     * @return int[]
     */
    public static function getOrderIds(int $userId): array
    {
        $orders = Order::find()->filterByUserId($userId)->all();
        return array_map(function($order){
            return $order->id;
        }, $orders);
    }

}
