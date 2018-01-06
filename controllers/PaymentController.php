<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\_forms\LoginForm;
use app\models\_forms\ContactForm;
use app\models\_forms\PaymentForm;
use app\models\Bank;
use app\models\Coupon;
use app\models\TransactionDetail;
use app\models\Order;
use app\models\Product;
use app\models\Role;

class PaymentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(!Role::isUser()){
            Yii::$app->session->setFlash('orderFailed');
            return $this->redirect(['home/index']);
        }

        $cart = Yii::$app->cart;
        $orderedItems = $cart->getItems();
        if(empty($orderedItems)) {
            return $this->redirect('/home/index');
        }

        $detail = new TransactionDetail();
        $model = new PaymentForm();
        $bank = Bank::findByAccountNumber(Bank::DEFAULT_ACCOUNT_NUMBER);
        $total = $cart->getCost();
        $detail->totalPrice = $total;
        $detail->transactionDate = date('Y-m-d');
        $detail->status = TransactionDetail::STATUS_NOT_PAID;
        $detail->bankId = $bank->id;

        if ($model->load(Yii::$app->request->post())) {
            if($model->isUsedCoupon()) {
                if($model->isCouponActive()) {
                    $coupon = Coupon::findByCouponCode($model->couponCode);
                    $detail->couponId = $coupon->id;
                    $detail->calculatePayment($coupon);
                } else {
                    return $this->redirect('index');
                }
            }
        }
        Yii::$app->session->set('payment', $detail);
        $model->couponCode = '';
        return $this->render('index', [
            'orderedItems' => $orderedItems,
            'total' => $total,
            'model' => $model,
            'detail' => $detail,
            'bank' => $bank
        ]);
    }

    public function actionCheckout()
    {
        $transactionId = TransactionDetail::saveTransactionDetail();
        Order::saveOrder($transactionId);
        Yii::$app->session->setFlash('orderSucceed');
        Product::destroySessionProducts();
        Yii::$app->cart->checkOut(false);
        return $this->redirect('/home/index');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}