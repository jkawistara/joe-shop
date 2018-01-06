<?php

use yii\bootstrap\Html;
use app\common\constants\CurrencyConstants as Currency;
use yii\bootstrap\ActiveForm;

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
                <li><?= $item->name ?> = <?= $item->getQuantity() ?> piece(s) (@ <?= $item->cost ?>)</li>
            </ul>
        <?php endforeach; ?>
        </div>

        <h4>Transfer To : <?= $bank->accountName ?> - <?= $bank->accountNumber ?> </h4>
        <h4>Total Price : <?= Yii::$app->formatter->asCurrency($detail->totalPrice  , $currency);?> </h4>
        <?php if(!empty($detail->totalPayment)): ?>
            <h4>Total Price After Discount :
                <?= Yii::$app->formatter->asCurrency($detail->totalPayment, $currency);?>
            </h4>
        <?php endif; ?>


            <?php $form = ActiveForm::begin([
                'id' => 'coupon-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-1'],
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

            <?php ActiveForm::end(); ?>
        <?php endif; ?>

        <h3 class="text-danger">
            <p>
                Total you must pay = <?= Yii::$app->formatter->asCurrency(
                        $detail->totalPayment ? $detail->totalPayment : $total , $currency
                ); ?>
            </p>
        </h3>

        <?= Html::a(Yii::t('app', 'Pay Now'), "/payment/checkout", ['class' => 'btn order btn-primary']);?>
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
