<?php

use yii\bootstrap\Html;
use app\common\constants\CurrencyConstants as Currency;
use yii\bootstrap\ActiveForm;
use app\models\Coupon;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Payment Details');
$currency = Currency::getCurrencyTypeLabel(Currency::CURRENCY_IDR);
?>
<div class="site-index">
    <div class="body-content">
        <?php if(!empty($orderedItems)): ?>

        <h3>Your order item on the list:</h3>
        <?php foreach($orderedItems as $item): ?>
            <ul class="row">
                <li><?= $item->name ?> =>    <?= $item->getQuantity() ?> piece(s) (@ <?= Yii::$app->formatter->asCurrency(
                        $item->cost , $currency
                    ); ?>)</li>
            </ul>
        <?php endforeach; ?>
        </div>
        <hr/>
        <table width="100%">
            <tr width="100%">
                <td width="100px">
                    <h4>Transfer To </h4>
                </td>
                <td width="10px">
                    :
                </td>
                <td>
                    <h4><?= $bank->accountName ?> - <?= $bank->accountNumber ?></h4>
                </td>
            </tr>
            <tr width="100%">
                <td>
                    <h4>Total Price </h4>
                </td>
                <td>
                    :
                </td>
                <td>
                    <h4><?= Yii::$app->formatter->asCurrency($detail->totalPrice, $currency);?> </h4>
                </td>
            </tr>
        </table>
        <hr/>
        <div align="left">
            <?php $form = ActiveForm::begin([
                'id' => 'coupon-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-1',
                        'style' => 'font-size: 18px;font-weight: normal;top: 3px;'
                    ],
                ],
            ]); ?>
            <?= $form->field($model, 'couponCode')
                ->textInput(['autofocus' => true])
                ->input('string', ['placeholder' => "Please enter coupon"])
            ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton(Yii::t('app', 'Check Coupon'),
                        ['class' => 'btn btn-default', 'name' => 'login-button'])
                    ?>
                </div>
            </div>
            <hr/>
            <?php ActiveForm::end(); ?>
            <?php endif; ?>
            <?php if(!empty($detail->totalPayment)): ?>
                <table width="100%">
                    <tr width="100%">
                        <td width="100px">
                            <h5>Got Discount </h5>
                        </td>
                        <td width="10px">
                            :
                        </td>
                        <td>
                            <h5><?php if (array_key_exists(Coupon::TYPE_COUPON_PRICE, $coupons)) {
                                    $value = Yii::$app->formatter->asCurrency($coupons[Coupon::TYPE_COUPON_PRICE], $currency);
                                } else {
                                    $value = $coupons[Coupon::TYPE_COUPON_PERCENTAGE] . '%';
                                }
                                echo $value; ?></h5>
                        </td>
                    </tr>
                    <tr width="100%">
                        <td>
                            <h5>Detail Payment </h5>
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <h5><? ?> </h5>
                            <h5><?php
                                $detailPayment = Yii::$app->formatter->asCurrency($total , $currency);
                                if (array_key_exists(Coupon::TYPE_COUPON_PRICE, $coupons)) {
                                    $detailPayment = $detailPayment . ' - ' . $value;
                                } else {
                                    $priceDiscount = Yii::$app->formatter->asCurrency(
                                            $coupons[Coupon::TYPE_COUPON_PERCENTAGE] * $total / 100 , $currency);
                                    $detailPayment = $detailPayment . ' - ' . $priceDiscount;
                                }
                                echo $detailPayment; ?></h5>
                        </td>
                    </tr>
                </table>
                <hr/>
            <?php endif; ?>

            <table width="100%" style="margin-top: -27px;">
                <tr width="100%">
                    <td width="100px">
                        <h3 style="color: red">
                                Total
                        </h3>
                    </td>
                    <td width="10px" style="color: red">
                        <h3>:</h3>
                    </td>
                    <td style="color: red">
                        <h3><?= Yii::$app->formatter->asCurrency(
                                $detail->totalPayment ? $detail->totalPayment : $total , $currency
                            ); ?></h3>
                    </td>
                </tr>
            </table>

            <hr/>
            <?= Html::a(Yii::t('app', 'Pay Now'), "/payment/checkout", ['class' => 'btn order btn-primary']);?>
        </div>



      </div>
</div>
<?php if (Yii::$app->getSession()->getFlash('couponNotFound')):?>
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="semibold"><?= Yii::t('app', 'Payment Failed')?></h4>
        <p class="mb10"><?= Yii::t('app', 'Your coupon not found') ?></p>
    </div>
<?php endif;?>
<?php if (Yii::$app->getSession()->getFlash('couponExpired')):?>
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="semibold"><?= Yii::t('app', 'Payment Failed')?></h4>
        <p class="mb10"><?= Yii::t('app', 'Your coupon has been expired') ?></p>
    </div>
<?php endif;?>
<?php if (Yii::$app->getSession()->getFlash('couponNotAvailable')):?>
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="semibold"><?= Yii::t('app', 'Payment Failed')?></h4>
        <p class="mb10"><?= Yii::t('app', 'Coupon stock is empty') ?></p>
    </div>
<?php endif;?>
