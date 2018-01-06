<?php

use yii\bootstrap\Html;
use app\common\constants\CurrencyConstants as Currency;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'List Of Products');
$currency = Currency::getCurrencyTypeLabel(Currency::CURRENCY_IDR);
?>
<div class="site-index">
    <div class="body-content">
        <?php if (Yii::$app->getSession()->getFlash('orderFailed')):?>
            <div class="alert alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 class="semibold"><?= Yii::t('app', 'Checkout Failed')?></h4>
                <p class="mb10"><?= Yii::t('app', 'You have to login first, before checkout') ?></p>
            </div>
        <?php endif;?>
        <?php if(!empty($orderedItems)): ?>
            <div class="row">
                Your cart:
            </div>
            <div class="row">
                <?php foreach($orderedItems as $item): ?>
                <ul class="row">
                    <li><?= $item->name ?> = <?= $item->getQuantity() ?> piece(s) (@ <?= $item->cost ?>)</li>
                </ul>
                <?php endforeach; ?>
                <p>Total you must paid = <?= Yii::$app->formatter->asCurrency($total , $currency); ?></p>
                <?= Html::a(Yii::t('app', 'Check Out'), "/payment/index", ['class' => 'btn order btn-default']);?>
            </div>
        <?php endif; ?>

        <div class="h1 text-center">
            <h2><?= $this->title ?></h2>
        </div>

        <div class="row">
            <?php foreach($products as $index => $product):
                 $quantity = Yii::$app->session->get("product-{$product->id}"); ?>

            <div class="col-lg-4 text-center">
                <h2><?= $product->name ?></h2>
                <img src="<?= $product->source ?>" class="img-responsive  center-block"
                     style="max-width: 50%; height: auto">
                <img/>
                <h3><?= Yii::$app->formatter->asCurrency($product->cost , $currency); ?></h3>
                <h4> Stock : <span id="prod-qty-<?=$index?>">
                        <?= $quantity ?>
                </span></h4>
                <?= Html::a(Yii::t('app', $quantity < 1 ? 'Out Of Stock' : 'Buy'),
                        "/home/order?id={$product->id}", [
                        'id' => "prod-buy-$index" ,
                        'class' => 'btn order btn-default '. ($quantity < 1 ? 'disabled' : ''),
                    ]); ?>
            </div>
            <?php endforeach;?>
        </div>
      </div>
</div>
