<?php

namespace app\modules\admin\controllers;

use app\models\Images;
use app\models\ImageWidgetModel;
use Imagine\Gd\Image;
use Yii;
use app\modules\admin\models\Categories;
use app\modules\admin\models\CategoriesSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
{
    public $layout = 'ml_admin.php';
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
                    'save-image' => ['POST'],
                    'delete-image' => ['POST'],
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
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex() : string
    {
        $searchModel = new CategoriesSearch();
        $searchModel->is_blog = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->getView()->title = Yii::t('app', 'Список категорий новостей');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdvertisements() : string
    {
        $searchModel = new CategoriesSearch();
        $searchModel->is_blog = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->getView()->title = Yii::t('app', 'Список категорий объявлений');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->options = json_encode($model->options);
        $model->translation = json_encode($model->translation);

        return $this->render('view', [
            'model' =>$model,
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();
        $model->is_blog = 1;
        $model->updated_at = date('Y-m-d H:i:s');
        
        $parentCat = ArrayHelper::map($model->find()->all(), 'id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'data' => [
                'catList' => $parentCat
            ]
        ]);
    }

    public function actionCreateAdv()
    {
        $model = new Categories();
        $model->is_blog = 0;
        $model->updated_at = date('Y-m-d H:i:s');

        $parentCat = ArrayHelper::map($model->find()->where(['is_blog' => 0, 'parent_id' => null])->all(), 'id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'data' => [
                'catList' => $parentCat
            ]
        ]);
    }

    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = date('Y-m-d H:i:s');
        $parentCat = ArrayHelper::map($model->find()->all(), 'id', 'title');

//        $model->options = json_decode($model->options, true);
//        $model->translation = json_decode($model->translation, true);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'data' => [
                'catList' => $parentCat
            ]
        ]);
    }

    public function actionUpdateAdv($id)
    {
        $model = $this->findModel($id);
        $model->is_blog = 0;
        $model->updated_at = date('Y-m-d H:i:s');
        $parentCat = ArrayHelper::map($model->find()->all(), 'id', 'title');

        $model->options = json_decode($model->options, true);
        $model->translation = json_decode($model->translation, true);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'data' => [
                'catList' => $parentCat
            ]
        ]);
    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->enableCsrfValidation = false;
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionSaveImage($subDir = 'categories')
    {
        $this->enableCsrfValidation = false;
        $result = [];

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $post = Yii::$app->request->post();
            $file = UploadedFile::getInstanceByName('Images[attachment]');

            $uploadModel = Yii::createObject(ImageWidgetModel::className());
            $uploadModel
                ->setDirName($post['Images']['module'])
                ->setImages($file)
                ->getDir();

            $model = (Yii::createObject(Images::className())->findOne(['item_id' => $post['Images']['item_id'], 'module' => $post['Images']['module']])) ? : new Images();

            $model->load($post);
            $model->validate();

            if ($model->hasErrors()) {
                $result = ['error' => $model->getFirstError('file')];
            }

            $uploadModel->uploadImage();

            $model->image_name = $uploadModel->getDirName().'/'.$uploadModel->getImageName();

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

                unlink(Yii::getAlias('@webroot').'/'.$model->image_name);

                return true;
            } else {
                throw new NotFoundHttpException('The requested page doesn`t exists.');
            }
        }

        throw new MethodNotAllowedHttpException();
    }
}
