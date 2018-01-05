<?php
/**
 * Coupon class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\_queries\CouponQuery;

/**
 * This is the model class for table "Coupon".
 *
 * @property integer $id
 * @property string  $couponCode
 * @property integer $type
 * @property float   $value
 * @property integer $quantity
 * @property string  $startDate
 * @property string  $endDate
 *
 */
class Coupon extends ActiveRecord
{
    const FORMAT_DATE = 'Y-m-d';

    const TYPE_COUPON_PRICE = 1;

    const TYPE_COUPON_PERCENTAGE = 2;

    const DEFAULT_QTY = 1;

    const STATUS_EXPIRED = 2;

    const STATUS_EMPTY = 3;

    const STATUS_AVAILABLE = 1;

    const STATUS_NOT_FOUND = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Coupons';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'couponCode', 'quantity', 'type', 'value'
            ], 'required'],
            [[
                'startDate', 'endDate'
            ], 'safe'],
            [[
                'quantity', 'type'
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

    public static function find(): CouponQuery
    {
        return new CouponQuery(self::class);
    }

    /**
     * @return string[]
     */
    public static function findAllCoupon(int $limit = null): array
    {
        $q = static::find();

        if(!empty($limit)){
            $q->limit($limit);
        }

        return $q->all();
    }

    public static function findAllStockCoupons(): array
    {
        return static::find()
            ->filterByQuantityMoreThan(self::DEFAULT_QTY)
            ->all();
    }

    public static function findById(int $id): Coupon
    {
        return static::find()
            ->filterById($id)
            ->one();
    }

    /**
     * @return array|null|ActiveRecord
     */
    public static function findByCouponCode(string $couponCode)
    {
        return static::find()
            ->filterByCouponCode($couponCode)
            ->one();
    }

    public static function checkCoupon(string $couponCode): int
    {
        $model = self::findByCouponCode($couponCode);
        if (empty($model)) {
            return self::STATUS_NOT_FOUND;
        }

        if (self::isQuantityAvailable($model)) {
            return self::isValidDate($model) ? (string) self::STATUS_AVAILABLE : self::STATUS_EXPIRED;
        }

        return self::STATUS_EMPTY;
    }

    public static function isQuantityAvailable(Coupon $model = null): bool
    {
        if (empty($model)) {
            return false;
        }

        return $model->quantity > 0 ? true : false;
    }

    public static function isValidDate(Coupon $model = null): bool
    {
        if (empty($model)) {
            return false;
        }

        $today = date(self::FORMAT_DATE);
        $startDate = date(self::FORMAT_DATE, strtotime($model->startDate));
        $endDate = date(self::FORMAT_DATE, strtotime($model->endDate));

        return $today >= $startDate && $today <= $endDate ? true : false;
    }

    public static function reduceQtyById($id)
    {
        $products = self::findById($id);
        $products->quantity -= 1;
        $products->save();
    }
}
