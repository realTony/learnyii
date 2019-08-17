<?php

namespace app\modules\admin\controllers;

use app\models\Images;
use app\models\Settings;
use Yii;
use app\models\Pages;
use app\models\PagesSearch;
use yii\base\DynamicModel;
use yii\base\ViewNotFoundException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends Controller
{
    public $layout = 'ml_admin.php';
    private $staticPages = [
      'main',
      'how-it-works',
      'privacy-policy',
    ];
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-image' => ['POST'],
                    'sort-image' => ['POST'],
                    'save-slide-image' => ['POST'],
                    'save-image' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['account#login']);
        }

        \Yii::$app->view->params['menu'] = \Yii::$app->getModule('admin')->params['menu'];

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdateStatic($id)
    {
        $model = $this->findModel($id);
        $link = $model->link;
        $options = [];
        $settings = (new Settings())
            ->find()
            ->where(['in', 'name', ['main_slider_max', 'advertisement_pageSize',
             'vip_message_ru', 'vip_message_uk', 'show_how_it_works']])
            ->all();

        foreach ($settings as $option) {
            $val = $option['option_value'];
            $options[$option['name']] = $val;
        }

        try {

            if( $model->load( Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update_'.$link, [
                'model' => $model,
                'settings' => $options
            ]);
        } catch (ViewNotFoundException $e) {
            $this->redirect(['index']);
        }
        return true;
    }
    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->getView()->title =  Yii::t('app', 'Редактировать страницу {name}', [
            'name' => $model->title,
        ]);

        if(in_array($model->link, $this->staticPages)) {
            return $this->actionUpdateStatic($model->id);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionStatic($link)
    {
        return $this->redirect(['index']);
    }

    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }



    public function actionSaveImage($subDir = 'main')
    {
        $this->enableCsrfValidation = false;

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@webroot').'/uploads/'.strtolower($post['Images']['module']).'/';

            if (!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }

            $file = UploadedFile::getInstanceByName('Images[attachment]');
            $model = new Images();
            $model->load($post);
            $model->validate();
            if ($model->hasErrors()) {
                $result = ['error' => $model->getFirstError('file')];
            }

            $model->image_name = strtotime('now').'_'.Yii::$app->getSecurity()->generateRandomString(6).'.'.$file->extension;

            $file->saveAs($dir.$model->image_name);

            $model->image_name = '/uploads/'.strtolower($post['Images']['module']).'/'.$model->image_name;
            $model->module = $post['Images']['module'];
            $model->item_id = $post['Images']['item_id'];
            $model->alt = $file->name;
            $count = $model::find()->andWhere(['module'=>$model->module])->count();
            $model->sort =  ($count > 0)? $count++ : 0;

            $model->save();

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
        throw new MethodNotAllowedHttpException();
    }

    public function actionSaveSlideImage()
    {
        $this->enableCsrfValidation = false;
        
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@webroot').'/uploads/'.strtolower($post['Images']['module']).'/';

            if (!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }

            $file = UploadedFile::getInstanceByName('Images[attachment]');
            $model = new Images();
            $model->load($post);
            $model->validate();
            if ($model->hasErrors()) {
                $result = ['error' => $model->getFirstError('file')];
            }

            $model->image_name = strtotime('now').'_'.Yii::$app->getSecurity()->generateRandomString(6).'.'.$file->extension;

            if ($file->saveAs($dir.$model->image_name)) {
                $slide = Yii::$app->image->load($dir.$model->image_name);
                $slide->background('#FFF', 0);
                $slide->resize(null, 500, \yii\image\drivers\Image::PRECISE)->save($dir.$model->image_name, 85);
            }

            $model->image_name = '/uploads/'.strtolower($post['Images']['module']).'/'.$model->image_name;
            $model->module = $post['Images']['module'];
            $model->item_id = $post['Images']['item_id'];
            $model->alt = $file->name;
            $count = $model::find()->andWhere(['module'=>$model->module])->count();
            $model->sort =  ($count > 0)? $count++ : 0;

            $model->save();

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
        throw new MethodNotAllowedHttpException();

    }

    public function actionDeleteImage()
    {
        $this->enableCsrfValidation = false;

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model = Yii::createObject(Images::className())->findOne($post['key']);

            if( $model->delete()) {
                return true;
            } else {
                throw new NotFoundHttpException('The requested page doesn`t exists.');
            }
        }

        throw new MethodNotAllowedHttpException();
    }

    public function actionSortImage($id)
    {
        $this->enableCsrfValidation = false;
        $param = [];
        $counter = 0;
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('sort');

            if ($post['oldIndex'] > $post['newIndex']) {
               $param = [
                            'and',
                            ['>=', 'sort', $post['newIndex']],
                            ['<', 'sort', $post['oldIndex']]
               ];
                $counter = 1;
            } else {
                $param = [
                    'and',
                    ['<=', 'sort', $post['newIndex']],
                    ['>', 'sort', $post['oldIndex']]
                ];
                $counter = -1;
            }

            Images::updateAllCounters(['sort' => $counter], ['and', ['module' => 'page', 'item_id' => $id], $param ]);
            Images::updateAll(['sort' => $post['newIndex']], ['id' => $post['stack'][$post['newIndex']]['key']]);
            return true;

        }

        throw new MethodNotAllowedHttpException();
    }

}
