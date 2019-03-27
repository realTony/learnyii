<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 25.03.2019
 * Time: 22:29
 */

namespace app\modules\admin\controllers;


use app\models\AdvertisementPost;
use app\models\AdvertisementPostSearch;
use Yii;
use yii\web\Controller;

class ModerationController extends Controller
{
    public $layout = 'ml_admin.php';

    public function beforeAction($action) : string
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['account#login']);
        }

        \Yii::$app->view->params['menu'] = \Yii::$app->getModule('admin')->params['menu'];

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex() : string
    {

        $searchModel = new AdvertisementPostSearch();
        $searchModel->is_approved = 0;
        $searchModel->authorId = false;
        $dataProvider = $searchModel->searchAll(Yii::$app->request->queryParams);

        $this->getView()->title = Yii::t('app', 'Список неподтвержденных объявлений');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionView($id) : string
    {
        $model = (Yii::createObject(AdvertisementPost::className()))->findOne($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionApprove($id) : object
    {
        $model = Yii::createObject(AdvertisementPost::className())
            ->findOne(['id' => $id]);

        $model->is_approved = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionBan($id) : object
    {
        $model = Yii::createObject(AdvertisementPost::className())
            ->findOne(['id' => $id]);

        $model->is_banned = 1;
        $model->save();

        return $this->redirect(['index']);
    }
}