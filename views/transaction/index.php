<?php
/**
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this         \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List Transactions');
$this->params['breadcrumbs'][] = $this->title;
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
                'couponId',
                'bankId',
                'status',
                'totalPrice',
                'totalPayment',
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
                'shippingId',
                'courierId',
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{documents} {update} {view}',
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