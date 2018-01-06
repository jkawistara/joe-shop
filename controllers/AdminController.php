<?php
/**
 * AdminController class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\_forms\LoginForm;
use app\models\_forms\ContactForm;
use app\models\_helpers\AdminHelper;
use app\models\Role;

class AdminController extends Controller
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
     * @return string
     */
    public function actionIndex()
    {
        $model = new LoginForm();
        if (AdminHelper::isAdmin()) {
            return $this->render('panel', ['model' => $model]);
        }

        if (Role::isUser()){
            return $this->render('@app/views/home/index', [
                'model' => $model,
            ]);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if (Role::isUser()){
            return $this->render('@app/views/home/index', [
                'model' => $model,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login(true)) {
            return $this->render('panel', [
                'model' => $model,
            ]);
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
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
