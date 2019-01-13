<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 29.12.2018
 * Time: 23:49
 */

namespace app\controllers;


use yii\web\Controller;

class BlogController extends Controller
{
    public function filters()
    {
        return [
          'accessControl',
        ];
    }

    public function actionIndex(){
        return $this->render('blog.twig');
    }

    public function accessRules()
    {
        return [

        ];
    }
}