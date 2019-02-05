<?php

namespace app\modules\admin\controllers;

use app\models\Images;
use Yii;
use app\models\Pages;
use app\models\PagesSearch;
use yii\base\DynamicModel;
use yii\base\ViewNotFoundException;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
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
        try {

            if( $model->load( Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            $model->options = json_decode($model->options, true);
            $model->translation = json_decode($model->translation, true);

            return $this->render('update_'.$link, [
                'model' => $model,
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

        if(in_array($model->link, $this->staticPages)) {
            return $this->actionUpdateStatic($model->id);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return true;
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
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

            if ($file->saveAs($dir.$model->image_name)) {
//                $img = Yii::$
            }
            $model->image_name = $dir.$model->image_name;
            $model->module = $post['Images']['module'];
            $model->item_id = $post['Images']['item_id'];
            $model->alt = $file->name;
            $count = $model::find()->andWhere(['module'=>$model->module])->count();
            $model->sort =  ($count > 0)? $count++ : 0;
            if( !$model->save()) {
                echo "<pre>";
                print_r($model->errors);
                echo "</pre>";die;
            }
            $model->save();

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
        throw new MethodNotAllowedHttpException();
    }


}
