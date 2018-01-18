<?php
/**
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

use yii\helpers\Html;
use app\models\TransactionDetail as Detail;

/* @var $this yii\web\View */
?>

<div class="transaction-form">

    <?php
    $form = \yii\widgets\ActiveForm::begin();
    $formId = $form->id;
    ?>
    <?= $form->field($model, 'id')->textInput(['readOnly' => true]) ?>
    <?= $form->field($model, 'status')->dropdownList(Detail::getArrayStatusLabels()); ?>
    <?= $form->field($model, 'shippingId')->textInput(['placeholder' => "Input shipping Id if it is available"]) ?>
    <?= $form->field($model, 'courierId')->dropdownList(Detail::getCourierLabels(),
        ['prompt'=> Yii::t('App', 'Select Couriers')]
    ); ?>
    <div class="form-group">
        <?= Html::submitButton( Yii::t('App', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
