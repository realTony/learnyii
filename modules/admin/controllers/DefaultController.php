<?php

namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    public $layout = 'ml_admin.php';
    private static $menu = [];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => [],
                        'roles' => ['?'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index' );
    }

    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest ) {
           \Yii::$app->response->redirect(['account#login']);
        }
        \Yii::$app->view->params['menu'] = \Yii::$app->getModule('admin')->params['menu'];

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
}
