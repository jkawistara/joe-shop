<?php
/**
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<div class="transaction-form">

    <?php
    $form = \yii\widgets\ActiveForm::begin();
    $formId = $form->id;
    ?>
    <?= $form->field($model, 'id')->textInput(['readOnly' => true]) ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'shippingId')->textInput() ?>
    <?= $form->field($model, 'courierId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( Yii::t('App', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
