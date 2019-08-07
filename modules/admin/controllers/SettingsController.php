<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Settings;
use app\models\SettingsSearch;
use app\modules\admin\models\SettingsFormModel;
use app\modules\admin\models\SaveDynamicSettings;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
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
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMain()
    {
        $model = new SettingsFormModel();
        $settings = Yii::createObject(Settings::className())->find()->all();
        $additions = Yii::createObject(Settings::className())->find()->
        where(['in', 'name', ['main_slider_max', 'advertisement_pageSize',
              'vip_message_ru', 'vip_message_uk', 'liqpay_public_key',
              'premium_alert_message']])->all();

        $propList = array_keys(get_object_vars($model));
        foreach ($settings as $option) {
            $name = $option['name'];

            //Lil bit fast hardcode not to change previous DB structure
            if( $name == 'account_settings') {
                break;
            }

            $val = $option['option_value'];
            $model->$name = $val;
        }

        foreach ($additions as $option) {
            $name = $option['name'];

            //Lil bit fast hardcode not to change previous DB structure
            if( $name == 'account_settings') {
                break;
            }

            $val = $option['option_value'];
            $model->$name = $val;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            Yii::$app->session->setflash( 'success', 'Saved');
        }
        return $this->render('main', [
            'model' => $model
        ]);
    }

    /**
     * Displays a single Settings model.
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
     * Creates a new Settings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Settings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Settings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Settings model.
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

    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMenu()
    {
        return $this->render('menu');
    }

    public function actionSeo() : string
    {
        $options = (Yii::createObject(Settings::className()))
            ->find()
            ->where(['>=', 'id', '8'])
            ->all();
        $options = ArrayHelper::map($options,'name', 'option_value');

        $model = new DynamicModel($options);
        $attributes = $model->getAttributes();

        foreach ($attributes as $attribute => $val) {
            if(! empty($val)) {
                $val = json_decode($val, true);
            }

            $default = [
                'lang' => 0,
                'options' => [
                    'seo_title' => '',
                    'seo_description' => '',
                    'seo_text' => '',
                    'no_index' => 0,
                    'no_follow' => 0,
                ],
                'translation' => [
                    'seo_title' => '',
                    'seo_description' => '',
                    'seo_text' => '',
                    'no_index' => 0,
                    'no_follow' => 0,
                ]
            ];

            $model->$attribute = (empty($val)) ? $default : $val;
        }

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $formData = $post['DynamicModel'];
            $settingsModel = new SaveDynamicSettings();

            if( $settingsModel->load($formData) && $settingsModel->saveSettings()) {
                Yii::$app->response->redirect(['/admin/settings/seo']);
            }
        }

        Yii::$app->getView()->title = Yii::t('app', 'Настройки SEO');
        return $this->render('seo-settings', [
            'model' => $model,
            'options' => $attributes
        ]);
    }

    public function getLabels() : array
    {
        $labels = [
            'account_settings' => Yii::t('app', 'Кабинет'),
            'account_create_settings' => Yii::t('app', 'Новое объявление'),
            'news_settings' => Yii::t('app', 'Новости'),
            'search_settings' => Yii::t('app', 'Поиск'),
            'advertisement_settings' => Yii::t('app', 'Объявления'),
            'inner_advertisement' => Yii::t('app', 'Внутренняя страница объявлений'),
            'user_advertisement' => Yii::t('app', 'Объявления пользователя'),
        ];

        return $labels;
    }
}
