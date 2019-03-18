<?php

namespace app\controllers;

use app\models\AdvertisementPost;
use app\models\ImageUpload;
use app\models\Pages;
use app\modules\admin\models\Categories;
use app\modules\admin\models\BlogPosts;
use app\models\Profile;
use app\models\RestoreForm;
use app\models\User;
use app\models\AjaxValidationTrait;
use app\widgets\LanguageSwitcher;
use dektrium\user\models\RecoveryForm;
use dektrium\user\traits\EventTrait;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\LoginForm;
use app\models\RegisterForm;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    use AjaxValidationTrait;
    use EventTrait;

    public $successUrl = 'myaccount';
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout'],
//                'rules' => [
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['account', 'logout'],
//                        'roles' => ['?']
//                    ]
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

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
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex() : string
    {
        $model = Yii::createObject(Pages::className())->find()->where(['link' => 'main'])->one();
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $categories = Yii::createObject(Categories::className());
        $news = Yii::createObject(BlogPosts::className());
        $advertisement = (Yii::createObject(AdvertisementPost::className()))
            ->find()->orderBy('isPremium DESC, published_at DESC')->limit(4)->all();

        $model->options = json_decode($model->options);
        $model->translation = json_decode($model->translation);

        if (! empty($model->options->promo)) {
            $categories->catName = (! empty($model->options->promo)) ? array_values((array)$model->options->promo) : [];
            $categories->category = (! empty($model->options->promo)) ? array_values((array)$model->options->promo) : [];
        }

        $slider = $model->imagesLinks;
        $advertIds = [];

        $adverts = (! empty($model->options->categories))? $categories->find()->where(['in', 'id', array_values($model->options->categories)])->all(): [];

        $news->category = (! empty($categories->category))? array_values((array)$model->options->promo): [];
        $promo = (! empty($categories->category))? $news->postsByCat : [];


        if( $currentLang == 'uk') {
            $model->options = $model->translation;
        }

        $title = (!empty($model->title)) ? $model->title : '';
        $title = ($currentLang == 'uk' && !empty($model->options->title)) ? $model->options->title : $title;

        $this->getView()->title = (empty($model->options->seo_title)) ? $title : $model->options->seo_title;

        return $this->render('index', [
                'model' => $model,
                'slider' => $slider,
                'adverts' => $adverts,
                'posts' => $advertisement,
                'news' => $categories->category,
                'promo' => $promo
        ]);
    }


    public function actionAccount()
    {
        $registerModel = new RegisterForm();
        $loginModel = new LoginForm();
        $restoreModel = $model = \Yii::createObject([
            'class'    => RecoveryForm::className(),
            'scenario' => RecoveryForm::SCENARIO_REQUEST,
        ]);

        $registerEvent = $event = $this->getFormEvent($registerModel);

        $this->trigger('beforeRegister', $registerEvent );

        $validateReset = $this->performAjaxValidation($restoreModel);
//        if( !empty($validateReset))
//            return $validateReset;
        //Account restoring
        if( $restoreModel->load(Yii::$app->request->post()) && $restoreModel->sendRecoveryMessage() ) {
            return $this->render('message/message', [
                'title'  => \Yii::t('user', 'Recovery message sent'),
                'module' => $this->module,
            ]);
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
        $model = Yii::createObject(Pages::className())->find()->where(['link' => 'how-it-works'])->one();

        $model->options = json_decode($model->options);
        $model->translation = json_decode($model->translation);

        return $this->render('how-it-works.twig', [
            'model' => $model
        ]);
    }

    public function actionPrivacyPolicy()
    {
        $model = Yii::createObject(Pages::className())->find()->where(['link' => 'privacy-policy'])->one();

        $model->options = json_decode($model->options);
        $model->translation = json_decode($model->translation);

        return $this->render('policy.twig', [
            'model' => $model
        ]);
    }

    public function actionPage($link)
    {
        $model = Yii::createObject(Pages::className())->find()->where(['link' => $link])->one();

        if(! empty($model)) {
            $model->options = (!empty($model->options))? json_decode($model->options) : [];
            $model->translation = (!empty($model->translation))? json_decode($model->translation) : [];

            return $this->render('policy.twig', [
                'model' => $model
            ]);
        } else {
            throw new NotFoundHttpException();
        }

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
            $this->successUrl = \yii\helpers\Url::to(['account#login']);
        }
    }
}
