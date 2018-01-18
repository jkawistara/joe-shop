<?php
/**
 * Payment form class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_forms;

use Yii;
use app\models\User;
use app\models\Coupon;
use yii\base\Model;

/**
 * PaymentForm is the model behind the Payment form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PaymentForm extends Model
{
    /**
     * @var string
     */
    public $couponCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['couponCode'], 'safe'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'couponCode' => Yii::t('common/labels', 'Coupon'),
        ];
    }

    public function isUsedCoupon(): bool
    {
        if (empty($this->couponCode)) {
            return false;
        }

        return true;
    }

    public function isCouponActive(): bool
    {
        $couponMessage = Coupon::checkCoupon($this->couponCode);
        if ($couponMessage === Coupon::STATUS_NOT_FOUND) {
            Yii::$app->session->setFlash('couponNotFound');
        } else if ($couponMessage === Coupon::STATUS_AVAILABLE) {
            return true;
        } else if ($couponMessage === Coupon::STATUS_EMPTY) {
            Yii::$app->session->setFlash('couponNotAvailable');
        } else if ($couponMessage === Coupon::STATUS_EXPIRED){
            Yii::$app->session->setFlash('couponExpired');
        }
        return false;
    }
}
