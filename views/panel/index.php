<?php
/**
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

use yii\helpers\Html;
use yii\grid\GridView;
use app\common\constants\CurrencyConstants as Currency;

/* @var $this         \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List Transactions');
$this->params['breadcrumbs'][] = $this->title;
$currency = Currency::getCurrencyTypeLabel(Currency::CURRENCY_IDR);
?>
<div class="card-box">
    <div>

        <h4 class="m-t-0 header-title"><b><?= Html::encode($this->title) ?></b></h4>

        <p class="text-muted m-b-30 font-13">
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'attribute' => 'couponId',
                    'format' => 'html',
                    'value' => function ($data) {
                        $value = $data->getCouponIdLabel();
                        if (empty($value)) {
                            return 'N/A';
                        }
                        return $value;
                    },
                ],
                [
                    'attribute' => 'bankId',
                    'format' => 'html',
                    'value' => function ($data) {
                        $value = $data->getBankIdLabel();
                        if (empty($value)) {
                            return 'N/A';
                        }
                        return $value;
                    },
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        $value = $data->getStatusLabel();
                        if (empty($value)) {
                            return 'N/A';
                        }
                        return $value;
                    },
                ],
                [
                    'attribute' => 'totalPrice',
                    'content' => function ($data) use ($currency) {
                        return Yii::$app->formatter->asCurrency($data->totalPrice, $currency);
                    }
                ],
                [
                    'attribute' => 'totalPayment',
                    'content' => function ($data) use ($currency) {
                        return Yii::$app->formatter->asCurrency($data->totalPayment, $currency);
                    }
                ],
                'transactionDate',
                [
                    'attribute' => 'paymentReceipt',
                    'format' => 'html',
                    'value' => function ($data) {
                        if(!empty($data['paymentReceipt'])) {
                            return Html::a('payment proof', $data['paymentReceipt']);
                        }
                    },
                ],
                'paymentDate',
                [
                    'attribute' => 'shippingId',
                    'format' => 'html',
                    'value' => function ($data) {
                        if (empty($data->shippingId)) {
                            return 'N/A';
                        }
                        return $data->shippingId;
                    },
                ],
                [
                    'attribute' => 'courierId',
                    'format' => 'html',
                    'value' => function ($data) {
                        $value = $data->getCourierLabel();
                        if (empty($value)) {
                            return 'N/A';
                        }
                        return $value;
                    },
                ],
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            $model; //unused
                            $key; //unused
                            $icon = Html::tag('span', '', ['class' => 'glyphicon  glyphicon-pencil']);
                            return Html::a($icon, $url, ['title' => Yii::t('app', 'Upload Payment Proof')]);
                        },
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>