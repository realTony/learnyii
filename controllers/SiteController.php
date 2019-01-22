<?php

namespace app\controllers;

use app\models\ImageUpload;
use app\models\Profile;
use app\models\RecoveryForm;
use app\models\RestoreForm;
use app\models\User;
use app\models\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use http\Url;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\ContactForm;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    use AjaxValidationTrait;
    use EventTrait;

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


    public function actionAccount()
    {
        $registerModel = new RegisterForm();
        $loginModel = new LoginForm();
        $restoreModel = new RecoveryForm();

        $registerEvent = $event = $this->getFormEvent($registerModel);

        $this->trigger('beforeRegister', $registerEvent );

        //$validateReset = $this->performAjaxValidation($restoreModel);

//        if( !empty($validateReset))
//            return $validateReset;
        //Account restoring
        if( $restoreModel->load(Yii::$app->request->post()) && $restoreModel->restore() ) {
            echo "<pre>";
            print_r('Success');
            echo "</pre>";
        }

        //Account registration
        $validateRegister = $this->performAjaxValidation($registerModel);

        if( !empty( $validateRegister ))
            return $validateRegister;

        if ( $registerModel->load(Yii::$app->request->post()) &&  $registerModel->register() ) {
            return $this->render('message/message', [
                'model' => $registerModel,
                'title'  => \Yii::t('user', 'Your account has been created'),
                'module' => $registerModel,
            ]);
        }

        $validateLogin = $this->performAjaxValidation($loginModel);
        if( !empty( $validateLogin )){
            return $validateLogin;}
        if ($loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            $imageUpload = new ImageUpload();
            $profile = Profile::findOne(['user_id'=>Yii::$app->user->getId()]);
            $session = Yii::$app->session;
            $image = ($imageUpload->fileExists($profile['profile_image']))? $profile['profile_image']: $imageUpload->getImage();
            $session->set( 'profile_image', $image );
            Yii::$app->response->redirect(['myaccount']);
        }

        $loginModel->password = '';
        $registerModel->password = '';
        $registerModel->password_repeat = '';

        return $this->render('account.twig', [ 'model' => $registerModel,
                                                        'loginModel' => $loginModel,
                                                        'restoreModel' => $restoreModel
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
