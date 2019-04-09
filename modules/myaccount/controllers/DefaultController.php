<?php

namespace app\modules\myaccount\controllers;

use app\models\AdvertisementPost;
use app\models\Images;
use app\models\ImageUpload;
use app\models\MetaTrait;
use app\models\PremiumRates;
use app\models\Profile;
use app\models\Settings;
use app\models\User;
use app\models\UserFav;
use LiqPay;
use Yii;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\modules\myaccount\models\EditProfileForm;
use app\modules\myaccount\models\ChangePassword;
use app\modules\myaccount\models\CreateAdvertisementPost;
use app\modules\admin\models\Categories;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    use MetaTrait;

    public static $breadcrumbs  = [];
    /**
     * Renders the index view for the module
     * @return string
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'success' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() : string
    {
        if( Yii::$app->user->isGuest ){
            Yii::$app->response->redirect(['account#login']);
        }
        $title = Yii::t('app', 'Личный кабинет');

        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет')]
        ];
        $user = User::findOne(['id'=>Yii::$app->user->getId()]);
        $profile = Profile::findOne(['user_id'=>Yii::$app->user->getId()]);
        $profile['profile_image'] = (!empty($profile['profile_image']))?'/'.$profile['profile_image']:Yii::getAlias('@web').'/images/empty_user.jpg';
        $settings = (Yii::createObject(Settings::className()))
            ->find()
            ->where(['name' => 'account_settings'])
            ->one();
        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $metaData = [
            'ru' => [
                'title' => (! empty($title)) ? $title : '',
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $title,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : $title,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : '',
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];

        $metaData = $metaData[$currentLang];

        Yii::$app->getView()->title = $metaData['seo_title'];

        return $this->render('index.php',[
            'user' => $user,
            'profile' => $profile,
            'breadcrumbs' => self::$breadcrumbs
        ]);
    }

    public function actionEdit() : string
    {
        if( Yii::$app->user->isGuest ){
            Yii::$app->response->redirect(['account#login']);
        }
        $title = Yii::t('app', 'Редактировать профиль');
        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет'), 'url' => [ '/myaccount' ]],
            ['label' => $title],
        ];

        $settings = (Yii::createObject(Settings::className()))
            ->find()
            ->where(['name' => 'account_settings'])
            ->one();
        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $metaData = [
            'ru' => [
                'title' => (! empty($title)) ? $title : '',
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $title,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => $title,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : '',
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];

        $metaData = $metaData[$currentLang];

        Yii::$app->getView()->title = $metaData['seo_title'];

        $user = User::findOne(['id'=>Yii::$app->user->getId()]);
        $profile = Profile::findOne(['user_id'=>Yii::$app->user->getId()]);
        $profile['profile_image'] = (!empty($profile['profile_image']))?'/'.$profile['profile_image']:Yii::getAlias('@web').'/images/empty_user.jpg';

        $editProfile = new EditProfileForm();
        $changePassword = new ChangePassword();
        $uploadImage = new ImageUpload;

        if ( $editProfile->load(Yii::$app->request->post()) && ( $editProfile->editProfile() )) {
            Yii::$app->response->redirect(['myaccount/edit']);
        }
        
        if( $changePassword->load(Yii::$app->request->post()) && $changePassword->changePassword() ) {
            Yii::$app->session->setFlash('success', \Yii::t('app', 'Пароль успешно изменён'));
            return $this->render('/message.php', [
                'title'  => Yii::t('app', 'Изменение пароля'),
                'module' => $this->module,
            ]);

        }
        return $this->render('edit.twig', [
            'model' => $editProfile,
            'changePassword' => $changePassword,
            'uploadImage' => $uploadImage,
            'profile' => $profile,
            'user' => $user,
            'breadcrumbs' => self::$breadcrumbs,
            'meta' => $metaData
        ]);
    }

    public function actionCreateAdvertisement()
    {
        $model = Yii::createObject(AdvertisementPost::className());
        $imgModel = Yii::createObject(Images::className());
        $user = User::findOne(['id'=>Yii::$app->user->getId()]);

        if( Yii::$app->user->isGuest ){
            Yii::$app->response->redirect(['account#login']);
        }


        if( Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $model->category_id = $post['catId'];
        }

        Yii::$app->getView()->title = Yii::t('app', 'Создать объявление');
        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет'), 'url' => [ Url::toRoute(['/myaccount']) ]],
            ['label' => Yii::t('app', 'Создать объявление')],
        ];

        if(Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->cities = (! empty($post['AdvertisementPost']['city']) )? $post['AdvertisementPost']['city'] : [];
            $model->district = (! empty($post['AdvertisementPost']['city_district']) )? $post['AdvertisementPost']['city_district'] : [];
        }

        if( $model->load(Yii::$app->request->post()) && $id = $model->createAdvertisement() ){
            $options = [];
            $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
            $settings = (new Settings())
                ->find()
                ->where(['in', 'name', ['vip_message_'.$currentLang]])
                ->all();

            foreach ($settings as $option) {
                $val = $option['option_value'];
                $options[$option['name']] = $val;
            }
            \Yii::$app->session->setFlash('successPost', \Yii::t('app', $options['vip_message_'.$currentLang]));


            $model = (new PremiumRates())
                ->find()
                ->all();

            return $this->render('premium_list', [
                'model' => $model,
                'breadcrumbs' => self::$breadcrumbs,
                'user' => $user,
                'advertisementId' => $id
            ]);
        }


        return $this->render('create_advertisement.php', [
            'model' => $model,
            'imageModel' => $imgModel,
            'user' => $user,
            'breadcrumbs' => self::$breadcrumbs
        ]);
    }

    public function actionUpdateAdvertisement($id)
    {
        if( Yii::$app->user->isGuest ){
            Yii::$app->response->redirect(['account#login']);
        }

        $model = AdvertisementPost::findOne($id);
        $user = User::findOne(['id'=>Yii::$app->user->getId()]);
        Yii::$app->getView()->title = Yii::t('app', 'Редактировать объявление');

        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет'), 'url' => [ Url::toRoute(['/myaccount']) ]],
            ['label' => Yii::t('app', 'Редактировать объявление')],
        ];

        if( Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $model->category_id = $post['catId'];
        }

        if( $model->load(Yii::$app->request->post()) && $model->createAdvertisement() ){
            return $this->redirect(['posts']);
        }

        return $this->render('edit.php', [
            'model' => $model,
            'breadcrumbs' => self::$breadcrumbs,
            'user' => $user
        ]);
    }

    public function actionFavorites()
    {

        $user = User::findOne(['id'=>Yii::$app->user->getId()]);
        $model = new AdvertisementPost();
        $favList = [];
        $userFav = (new UserFav())
        ->find()
        ->select(['advertisement_id'])
        ->where(['user_id' => $user->id])
        ->asArray()
        ->all();

        foreach ($userFav as $fav) {
            $favList[] = $fav['advertisement_id'];
        }

        $advPosts = $model
            ->find()
            ->where(['in', 'id', $favList]);

        $countQuery = clone $advPosts;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,

        ]);
        $title = Yii::t('app', 'Избранные');

        $settings = (Yii::createObject(Settings::className()))
            ->find()
            ->where(['name' => 'account_settings'])
            ->one();
        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];
        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет'), 'url' => [ Url::toRoute(['/myaccount']) ]],
            ['label' => Yii::t('app', $title)],
        ];

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $metaData = [
            'ru' => [
                'title' => (! empty($title)) ? $title : '',
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $title,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => $title,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : '',
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];
        $metaData = $metaData[$currentLang];
        $models = $advPosts->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        Yii::$app->getView()->title = $metaData['seo_title'];

        return $this->render('favorites', [
            'breadcrumbs' => self::$breadcrumbs,
            'models' => $models,
            'pages' => $pages,
            'user' => $user,
        ]);
    }

    public function actionMakeFav()
    {
        $this->enableCsrfValidation = false;
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $user = User::findOne(Yii::$app->user->id);
            $fav = Yii::createObject(UserFav::className());
            $exists = $fav->find()->where(['advertisement_id' => $post['id']])->exists();
            if(! $exists) {
                $fav->user_id = $user->id;
                $fav->advertisement_id  = $post['id'];
                $fav->save();
            }

            return true;
        } else {
            throw new MethodNotAllowedHttpException();
        }
    }

    public function actionRemoveFav()
    {
        $this->enableCsrfValidation = false;
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $user = User::findOne(Yii::$app->user->id);
            $fav = Yii::createObject(UserFav::className());
            $exists = $fav->find()->where(['advertisement_id' => $post['id']])->andWhere(['user_id' => $user->id])->exists();
            if($exists) {
                $item = $fav->find()->where(['advertisement_id' => $post['id']])->andWhere(['user_id' => $user->id])->one();
                $fav->findOne($item->id)->delete();
            }

            return true;
        } else {
            throw new MethodNotAllowedHttpException();
        }
    }

    public function actionUpdateCat()
    {
        if( Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $id = $post['id'];
            $cat = new Categories();
            $cat->parent = $id;
            $list  = $cat->parents;
            $options = '<option value="">'.Yii::t('app', 'Подкатегория').'</option>';

            foreach ( $list as $item => $val) {
                $options .= '<option value="'.$item.'">'.$val.'</option>';
            }

            $type = '';
            switch ($id) {
                case 8:
                    $type = 'transport';
                    break;
                case 9:
                    $type = 'advertisement';
                    break;
                case 10:
                    $type = 'freelancers';
                    break;
            }

            $data = ['type' => $type, 'data' => $options ];
            $data = json_encode($data);
            return $data;
        }

        return false;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPosts() : string
    {
        $query = [];
        $query = Yii::$app->getRequest()->queryParams;
        $user = User::findOne(['id'=>Yii::$app->user->getId()]);
        $model = new AdvertisementPost();
        $advPosts = $model
            ->find()
            ->where(['authorId' => $user->id, 'is_approved' => 1, 'is_archived' => 0]);

        $countQuery = clone $advPosts;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,

        ]);
        $title = Yii::t('app', 'Мои объявления');

        $settings = (Yii::createObject(Settings::className()))
            ->find()
            ->where(['name' => 'account_settings'])
            ->one();
        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];
        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет'), 'url' => [ Url::toRoute(['/myaccount']) ]],
            ['label' => Yii::t('app', $title)],
        ];

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $metaData = [
            'ru' => [
                'title' => (! empty($title)) ? $title : '',
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $title,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => $title,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : '',
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];
        $metaData = $metaData[$currentLang];
        $models = $advPosts->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('isPremium DESC, published_at DESC')
            ->all();
        Yii::$app->getView()->title = $metaData['seo_title'];


        if( ! empty($query['type'])) {
            switch ($query['type']) {
                case 'active':
                    $model = new AdvertisementPost();
                    $advPosts = $model
                        ->find()
                        ->where(['authorId' => $user->id, 'is_approved' => 1, 'is_archived' => 0]);

                    $countQuery = clone $advPosts;
                    $pages = new Pagination([
                        'totalCount' => $countQuery->count(),
                        'pageSize' => 5,

                    ]);

                    $models = $advPosts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->orderBy('isPremium DESC, published_at DESC')
                        ->all();

                    break;
                case 'moderation':
                    $model = new AdvertisementPost();
                    $advPosts = $model
                        ->find()
                        ->where(['authorId' => $user->id, 'is_approved' => 0, 'is_archived' => 0]);

                    $countQuery = clone $advPosts;
                    $pages = new Pagination([
                        'totalCount' => $countQuery->count(),
                        'pageSize' => 5,

                    ]);

                    $models = $advPosts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->orderBy('isPremium DESC, published_at DESC')
                        ->all();

                    break;
                case 'archived':
                    $model = new AdvertisementPost();
                    $advPosts = $model
                        ->find()
                        ->where(['authorId' => $user->id, 'is_archived' => 1])
                        ->orderBy('isPremium DESC, published_at DESC');

                    $countQuery = clone $advPosts;
                    $pages = new Pagination([
                        'totalCount' => $countQuery->count(),
                        'pageSize' => 5,

                    ]);


                    $models = $advPosts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                    break;
            }
        }

        return $this->render('user_posts', [
            'breadcrumbs' => self::$breadcrumbs,
            'models' => $models,
            'pages' => $pages,
            'user' => $user,
            'type' => !empty($query['type'])? $query['type'] : 'active'
        ]);

    }


    public function actionPremiumRates($id) : string
    {
        if(! Yii::$app->user->isGuest) {
            $model = (new PremiumRates())
                ->find()
                ->all();

            return $this->render('premium_list', [
                'model' => $model
            ]);
        } else {
            throw new NotFoundHttpException();
        }

    }

    /**
     * @param $id
     * @param $link
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSetPremium($id, $link)
    {
        if(! Yii::$app->user->isGuest) {

            $settings = (Yii::createObject(Settings::className()));
            $public_key = ($settings->findOne(['name' => 'liqpay_public_key']))->option_value;
            $private_key = ($settings->findOne(['name' => 'liqpay_private_key']))->option_value;;
            $user = Yii::$app->user->id;
            $advertisement = (Yii::createObject(AdvertisementPost::className()))
                ->findOne(['id' => $id]);
            $premiumPack = (Yii::createObject(PremiumRates::className()))
                ->find()->where(['id' => $link])->all();
            $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

            $description = $premiumPack[0]->rate;

            if( $currentLang == 'uk') {
                $description = $premiumPack[0]->rate_ua;
            }

            $liqpay = new LiqPay($public_key, $private_key);

            $settings = [
                'action'         => 'pay',
                'amount'         => floatval($premiumPack[0]->price),
                'currency'       => 'UAH',
                'description'    => $description,
                'order_id'       => 'order_id_1',
                'version'        => '3',
                'sandbox'        => YII_ENV_DEV
            ];

            $html = $liqpay->cnb_form($settings);

            return  $this->renderAjax('pricelist', [
                'model' => $premiumPack,
                'advertisementId' => $id
            ]);
        } else {
            throw new NotFoundHttpException();
        }

    }

    /**
     *
     */
    public function actionSaveImage()
    {
        $profile = Profile::findOne(['user_id'=>Yii::$app->user->getId()]);
        $model = new ImageUpload;
        $editProfile = new EditProfileForm();

        if( \Yii::$app->request->isPost ){
            if(!empty($profile->profile_image) && ! strpos('empty_user', $profile->profile_image )) {
                $model->deleteCurrentImage($profile->profile_image);
            }

            $file = UploadedFile::getInstance($model, 'imageFile');
            $editProfile->saveImage($model->uploadImage($file, $profile->profile_image));
        }
        Yii::$app->response->redirect(['myaccount/edit']);
    }

    /**
     * Ajax method of removing avatar from user profile
     *
     * @return string
     */
    public function actionRemovePhoto()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new ImageUpload();
        $empty_image = $model->getImage();
        if(Yii::$app->request->isAjax){
            $profile = Profile::findOne(['user_id'=>Yii::$app->user->getId()]);
            $model->deleteCurrentImage($profile->profile_image);
            $profile->profile_image = '/images/empty_user.jpg';
            $profile->save();
        }
        return $empty_image;
    }

    public function actionRemoveAdvImg()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Yii::createObject(Images::className());
        $imgModel = new ImageUpload();
        if( Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $img = '';
            $thumb = '';
            $item = $model->findOne(['id' => $post['id']]);
            $img = $item->image_name;
            $thumb = str_replace('advertisementpost/', 'advertisementpost/thumbnails/', $item->image_name);

            $model->findOne(['image_name' => $img])
            ->delete();
            $model->findOne(['image_name' => $thumb])
                ->delete();

            $imgModel->deleteCurrentImage($img);
            $imgModel->deleteCurrentImage($thumb);

            echo 'ok';
        }
    }

    /**
     * Remove Advertisement post item
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $post = AdvertisementPost::findOne($id);
        $post->is_archived = 1;
        $post->is_approved = 0;
        $post->save();

        return $this->redirect(['posts']);
    }
    
    public function actionSuccess()
    {
        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->isPost;
            
            echo "<pre>";
            print_r($post);
            echo "</pre>";
        }
    }


}
