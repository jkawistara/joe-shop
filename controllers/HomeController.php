<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\_forms\LoginForm;
use app\models\_forms\ContactForm;
use app\models\_forms\RegisterForm;
use app\models\Product;
use app\models\Role;
use app\models\Order;

class HomeController extends Controller
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
        if (Role::isAdmin()){
            return $this->redirect('/panel/index');
        }

        $cart = Yii::$app->cart;
        $orderedItems = $cart->getItems();
        $total = $cart->getCost();
        $products = Product::findProducts();
        return $this->render('index', [
            'products' => $products,
            'orderedItems' => $orderedItems,
            'total' => $total
        ]);
    }

    public function actionOrder($id)
    {
        $product = Product::findOne($id);
        if ($product) {
            $_qty = Yii::$app->session->get("product-{$id}");
            Yii::$app->session->set("product-{$id}", $_qty - 1);
            Yii::$app->cart->create($product);
            return $this->redirect(['index']);
        }
    }

    /**
     * @return Response
     */
    public function actionUpdate(int $id, int $quantity)
    {
        $product = Product::findOne($id);
        if ($product) {
            Yii::$app->cart->update($product, $quantity);
            return $this->redirect(['index']);
        }
    }

    /**
     * @return bool|Response
     */
    public function actionCheckout()
    {
        if(!Role::isUser()){
            Yii::$app->session->setFlash('orderFailed');
            return $this->redirect(['index']);
        }

        return $this->redirect(['payment']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->saveData()) {
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('register', [
            'model' => $model
        ]);
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
