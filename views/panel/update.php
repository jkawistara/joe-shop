<?php
/**
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Transaction',
]) . $model->id;
?>
<div class="card-box">
    <div class="project-update">

        <h4 class="m-t-0 header-title"><b><?= Html::encode($this->title) ?></b></h4>
        <?= $this->render('_form', [
            'model' => $model
        ]) ?>

    </div>
</div>