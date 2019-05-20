<?php

namespace app\controllers;

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
        $model = Yii::createObject(Pages::className())->find()->where(['link' => 'main'])->one();
        MetaTrait::setModel($model);
        MetaTrait::getMeta();

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $categories = Yii::createObject(Categories::className());
        $news = Yii::createObject(BlogPosts::className());
        $advertisement = (Yii::createObject(AdvertisementPost::className()))
            ->find()
            ->andWhere(['is_approved' => 1])
            ->andWhere(['is_banned' => 0])
            ->andWhere(['is_archived' => 0])
            ->orderBy('isPremium DESC, published_at DESC')->limit(12)->all();


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


        if( $currentLang == 'uk') {
            $model->options = $model->translation;
        }

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

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionHowItWorks() : string
    {
        $model = Yii::createObject(Pages::className())->find()->where(['link' => 'how-it-works'])->one();
        MetaTrait::setModel($model);
        $metaData = MetaTrait::getMeta();
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

        if(! empty($model)) {

            if(! empty($model->options)) {
                $model->options->content = (!empty($model->options->content)) ?: '';
                $model->options->content = ($currentLang == 'uk' && !empty($model->translation->content)) ? $model->translation->content : $model->options->content;
                $model->options->after_content = ($currentLang == 'uk' && !empty($model->translation->after_content)) ? $model->translation->after_content : $model->options->after_content;
                $model->options->after_content = (!empty($model->options->after_content)) ?: '';
            }

            $model->title = $metaData['title'];
            $breadcrumbs = ['label' => Yii::t('app', $metaData['title'])];

            return $this->render('how-it-works.php', [
                'model' => $model,
                'breadcrumbs' => $breadcrumbs
            ]);
        } else {
            return new NotFoundHttpException();
        }
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPrivacyPolicy() : string
    {
        $model = Yii::createObject(Pages::className())->find()->where(['link' => 'privacy-policy'])->one();
        MetaTrait::setModel($model);
        $metaData = MetaTrait::getMeta();
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $model->title = $metaData['title'];

        if(! empty($model)) {

            if(! empty($model->options)) {
                $model->options->content = (!empty($model->options->content)) ? $model->options->content : '';
                $model->options->content = ($currentLang == 'uk' && !empty($model->options->content)) ? $model->translation->content : $model->options->content;
            }

            $breadcrumbs = ['label' => Yii::t('app', $metaData['title'] )];

            return $this->render('page', [
                'model' => $model,
                'breadcrumbs' => $breadcrumbs
            ]);
        } else {
            throw new NotFoundHttpException();
        }

    }

    /**
     * @param $link
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPage($link) : string
    {
        $model = Yii::createObject(Pages::className())->find()->where(['link' => $link])->one();
        MetaTrait::setModel($model);
        $metaData = MetaTrait::getMeta();
        if(empty($model)) {
            throw new NotFoundHttpException();
        }

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

        if(! empty($model->options)) {
           $model->options->content = (!empty($model->options->content))? $model->options->content : '';
           $model->options->content = ($currentLang == 'uk' && !empty($model->options->content)) ? $model->translation->content : $model->options->content;
        }

        $model->title = $metaData['title'];
        $breadcrumbs = ['label' => Yii::t('app', $metaData['title'] )];

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
//                $item = str_replace('\'', '', $item);
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
