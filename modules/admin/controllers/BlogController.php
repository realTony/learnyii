<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\BlogPosts;
use app\modules\admin\models\Categories;
use app\modules\admin\models\BlogPostsSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BlogController implements the CRUD actions for BlogPosts model.
 */
class BlogController extends Controller
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
     * Lists all BlogPosts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogPostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $this->title = 'Posts';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlogPosts model.
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

    /**
     * Creates a new BlogPosts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['account#login']);
        }

        $model = new BlogPosts();
        $categories = new Categories();

        $catList = ArrayHelper::map($categories->find(['is_blog' => 1])->all(), 'id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $catList
        ]);
    }

    /**
     * Updates an existing BlogPosts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = new Categories();
        $catList = ArrayHelper::map($categories->find(['is_blog' => 1])->all(), 'id', 'title');

        $model->options = json_decode($model->options, true);
        $model->translation = json_decode($model->translation, true);
        if($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();
            if( !isset($post['post_image'])) {
                $model->post_image = (!empty($model->post_image)) ? $model->post_image : '';
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $catList
        ]);
    }

    /**
     * Deletes an existing BlogPosts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->response->redirect(['admin/blog/index']);
//        return $this->redirect(['admin/blog/']);
    }

    /**
     * Finds the BlogPosts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogPosts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}