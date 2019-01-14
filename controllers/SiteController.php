<?php

namespace app\controllers;

use app\models\User;
use http\Url;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public $successUrl = 'Success';
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback']
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index.twig');
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
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Registration action
     * 
     * @return Response|string
     */
    public function actionAccount()
    {
        $registerModel = new RegisterForm();
        $loginModel = new LoginForm();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if ( $registerModel->load(Yii::$app->request->post()) && ( $registerModel->register() || $loginModel->login() )) {
            Yii::$app->response->redirect(['myaccount']);
        }

        if ($loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            Yii::$app->response->redirect(['myaccount']);
        }
        $loginModel->password = '';
        $registerModel->password = '';
        $registerModel->password_repeat = '';

        return $this->render('account', [
            'model' => $registerModel,
            'loginModel' => $loginModel
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionHowItWorks()
    {
        return $this->render('how-it-works.twig');
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        $user = User::find()->where(['email'=> $attributes['email']])->one();
        if(!empty($user)){
            Yii::$app->user->login($user);
        }else{
            $session = Yii::$app->session;
            $session['attributes'] = $attributes;
            $this->successUrl = \yii\helpers\Url::to(['site/account']);
        }
    }
}
