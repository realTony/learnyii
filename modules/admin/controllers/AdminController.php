<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 24.01.2019
 * Time: 1:33
 */

namespace app\modules\admin\controllers;


use yii\web\Controller;
use Yii;

class AdminController extends Controller
{
    public $layout = 'admin.twig';
    
    public function actionIndex()
    {
        return $this->render('index.twig');
    }

}