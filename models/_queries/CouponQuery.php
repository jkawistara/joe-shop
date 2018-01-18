<?php
/**
 * CouponQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\Coupon;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Coupon]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see Coupon
 */
class CouponQuery extends ActiveQuery
{
    public function filterById(int $id): CouponQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function filterByQuantityMoreThan(int $number): CouponQuery
    {
        return $this->andWhere(['>=', 'quantity', $number]);
    }

    public function filterByCouponCode(string $code): CouponQuery
    {
        return $this->andWhere(['couponCode' => $code]);
    }

    public function filterByType(int $type): CouponQuery
    {
        return $this->andWhere(['type' => $type]);
    }
}
