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
    <?= $form->field($model, 'paymentReceipt')->fileInput(); ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(
                $model->isNewRecord ? Yii::t('admin/general', 'Create') : Yii::t('admin/general', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
            ) ?>
        </div>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
