<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\models\Role;

?>
<?php
$isUser = false;
$isAdmin = false;
$isGuest = Yii::$app->user->isGuest;
if(!$isGuest) {
    $isUser = Role::isUser();
    $isAdmin = Role::isAdmin();
}
$home = ['label' => 'Home', 'url' => ['/home/index']];
$items = [
    $home,
    ['label' => 'Login', 'url' => ['/home/login']]
];
$itemLabel = '';

if ($isUser) {
    $items = [
        $home,
        ['label' => Yii::t('app', 'Transactions'), 'url' => ['/home/order']]
    ];
    $items[] = '<li>'
        . Html::beginForm(['/home/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->name . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}

if ($isAdmin) {
    $items = [
        $home,
        ['label' => Yii::t('app', 'User Transactions'), 'url' => ['/panel/order']]
    ];
    $items[] = '<li>'
        . Html::beginForm(['/admin/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->name . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}

NavBar::begin([
    'brandLabel' => 'Joe Shopping',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);

NavBar::end();
?>