<?php

namespace app\modules\myaccount\controllers;

use app\models\ImageUpload;
use app\models\Profile;
use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\modules\myaccount\models\EditProfileForm;
use app\modules\myaccount\models\ChangePassword;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    public static $breadcrumbs  = [];
    /**
     * Renders the index view for the module
     * @return string
     */
    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = ($action->id !== "<action>");
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if( Yii::$app->user->isGuest ){
            Yii::$app->response->redirect(['account#login']);
        }
        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет')]
        ];
        $user = User::findOne(['id'=>Yii::$app->user->getId()]);
        $profile = Profile::findOne(['user_id'=>Yii::$app->user->getId()]);
        $profile['profile_image'] = (!empty($profile['profile_image']))?'/'.$profile['profile_image']:Yii::getAlias('@web').'/images/empty_user.jpg';

        return $this->render('index.twig',[
            'user' => $user,
            'profile' => $profile,
            'breadcrumbs' => self::$breadcrumbs
        ]);
    }

    public function actionEdit()
    {
        if( Yii::$app->user->isGuest ){
            Yii::$app->response->redirect(['account#login']);
        }
        self::$breadcrumbs = [
            ['label' => Yii::t('app', 'Личный кабинет'), 'url' => [ Url::toRoute(['/myaccount']) ]],
            ['label' => Yii::t('app', 'Редактировать профиль')],
        ];

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

        }
        return $this->render('edit.twig', [
            'model' => $editProfile,
            'changePassword' => $changePassword,
            'uploadImage' => $uploadImage,
            'profile' => $profile,
            'user' => $user,
            'breadcrumbs' => self::$breadcrumbs
        ]);
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


}
