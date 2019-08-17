<?php

namespace app\controllers;

use app\components\L10nTrait;
use app\models\AdvertisementPost;
use app\models\Cities;
use app\models\CityRegions;
use app\models\ImageUpload;
use app\models\MetaTrait;
use app\models\Pages;
use app\modules\admin\models\Categories;
use app\modules\admin\models\BlogPosts;
use app\models\Profile;
use app\models\User;
use app\models\AjaxValidationTrait;
use dektrium\user\models\RecoveryForm;
use dektrium\user\traits\EventTrait;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\LoginForm;
use app\models\RegisterForm;

class SiteController extends Controller
{
    use AjaxValidationTrait;
    use EventTrait;
    use MetaTrait;
    use L10nTrait;

    public $successUrl = 'myaccount';

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
     * Main page action
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex() : string
    {
        $model = Yii::createObject(Pages::className())
                    ->find()
                    ->where(['link' => 'main'])
                    ->one();

        $model->options = ($this->getLanguage() == 'uk') ?
            $model->translation : $model->options ;
        $this->setMetaData($model);

        $categories = Yii::createObject(Categories::className());
        $news = Yii::createObject(BlogPosts::className());
        $advertisement = (Yii::createObject(AdvertisementPost::className()))
            ->find()
            ->andWhere(['is_banned' => 0])
            ->andWhere(['is_archived' => 0])
            ->andWhere(['isPremium' => 0])
            ->orderBy('published_at DESC')
            ->limit(8)
            ->all();
        $premiumAdv = (Yii::createObject(AdvertisementPost::className()))
        ->find()
        ->andWhere(['is_banned' => 0])
        ->andWhere(['isPremium' => 1])
        ->andWhere(['is_archived' => 0])
        ->orderBy('RAND()')
        ->limit(4)
        ->all();

        if (! empty($model->options->promo)) {
            $categories->category = (! empty($model->options->promo)) ? array_values((array)$model->options->promo) : [];

            if(! empty($categories->category)) {
                $categories->catName = (! empty($model->options->promo)) ? array_values((array)$model->options->promo) : [];
            }
        }

        $slider = $model->imagesLinks;
        $advertIds = [];

        $adverts = (! empty($model->options->categories))? $categories->find()
            ->where(['in', 'id', array_values($model->options->categories)])
            ->all(): [];

        $news->category = (! empty($categories->category))? array_values((array)$model->options->promo): [];
        $promo = (! empty($categories->category))? $news->postsByCat : [];
        $show_how_it_works = (! empty($model->options->show_how_it_works))? $model->options->show_how_it_works : false;

        if( $this->getLanguage() == 'uk') {
            $model->options = $model->translation;
        }

        return $this->render('index', [
                'model' => $model,
                'slider' => $slider,
                'adverts' => $adverts,
                'premAdverts' => $premiumAdv,
                'posts' => $advertisement,
                'news' => $categories->category,
                'promo' => $promo,
                'show_how_it_works' => $show_how_it_works
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

    /**
     * How it works page
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionHowItWorks() : string
    {
        try{
            $model = Yii::createObject(Pages::className())
                        ->find()
                        ->where(['link' => 'how-it-works'])
                        ->one();

            $model->options = ($this->getLanguage() == 'uk') ?
               $model->translation : $model->options ;
            $this->setMetaData($model);
            $meta = $this->getMetaData();
            $breadcrumbs = ['label' => Yii::t('app', $meta['title'])];

            return $this->render('how-it-works.php', [
                    'model' => $model,
                    'breadcrumbs' => $breadcrumbs
            ]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    public function actionPrivacyPolicy() : string
    {
        try {
            $model = Yii::createObject(Pages::className())
                        ->find()
                        ->where(['link' => 'privacy-policy'])
                        ->one();
            $model->options = ($this->getLanguage() == 'uk') ?
                $model->translation : $model->options ;

            $this->setMetaData($model);
            $meta = $this->getMetaData();

            $breadcrumbs = ['label' => Yii::t('app', $meta['title'])];

            return $this->render('page', [
               'model' => $model,
               'breadcrumbs' => $breadcrumbs
            ]);
        } catch ( NotFoundHttpException $exception) {
            throw new NotFoundHttpException();
        }
    }

    public function actionPage($link) : string
    {
        $model = Yii::createObject(Pages::className())
                    ->find()
                    ->where(['link' => $link])
                    ->one();

        $model->options = ($this->getLanguage() == 'uk') ?
            $model->translation : $model->options ;
        $this->setMetaData($model);
        $meta = $this->getMetaData();
        $breadcrumbs = ['label' => Yii::t('app', $meta['title'])];

        return $this->render('page', [
           'model' => $model,
           'breadcrumbs' => $breadcrumbs
        ]);
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

    public function actionAutocomplete()
    {
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();


            $cities = (new Cities())
                ->find();

            $city  = $post['city'];
            $district = (! empty($post['district'])) ? $post['district'] : '';
            $found = false;

            if(Yii::$app->language == 'uk-Uk')
                $cities = $cities->where(['like', 'name_ua', $city])
                    ->all();
            else
                $cities = $cities->where(['like', 'name', $city])
                    ->all();
            $citiesList = $jsonList = [];
            if(Yii::$app->language == 'uk-Uk')
                $citiesList = ArrayHelper::map($cities, 'id', 'name_ua');
            else
                $citiesList = ArrayHelper::map($cities, 'id', 'name');

            foreach ($citiesList as $k => $item) {
                $jsonList['label'] = $item;
                $jsonList['value'] = $item;
                $citiesList[$k] = $item;
            }

            if(empty($post['district']) )
                return json_encode($citiesList);
            else {
                if(empty($post['city']) && !empty($post['district'])) {
                    $district = $post['district'];

                    $found = (new CityRegions())
                        ->find();

                    if(Yii::$app->language == 'uk-Uk')
                        $found = $found->andWhere(['like', 'region_ua', $district]);
                    else
                        $found = $found->andWhere(['like', 'region', $district]);

                    $found = $found->limit('1')->all();

                    if(Yii::$app->language == 'uk-Uk')
                        $citiesList = ArrayHelper::map($found, 'id', 'region_ua');
                    else
                        $citiesList = ArrayHelper::map($found, 'id', 'region');

                    return json_encode($citiesList);
                }

                $cities = (new Cities())
                    ->find();
                if(Yii::$app->language == 'uk-Uk')
                    $cities = $cities->where(['name_ua' => $city])
                        ->one();
                else
                    $cities = $cities->where(['name' => $city])
                        ->one();

                    $found = (new CityRegions())
                        ->find()
                        ->where(['city_id' => $cities->id]);

                    if(Yii::$app->language == 'uk-Uk')
                        $found = $found->andWhere(['like', 'region_ua', $district]);
                    else
                        $found = $found->andWhere(['like', 'region', $district]);

                    $found = $found->all();

                    if(Yii::$app->language == 'uk-Uk')
                        $citiesList = ArrayHelper::map($found, 'id', 'region_ua');
                    else
                        $citiesList = ArrayHelper::map($found, 'id', 'region');

                return json_encode($citiesList);

            }
        } else {
            throw new NotFoundHttpException();
        }
    }
}
