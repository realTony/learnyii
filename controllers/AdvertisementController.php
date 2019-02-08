<?php


namespace app\controllers;


use yii\web\Controller;

class AdvertisementController extends Controller
{

    public function actionIndex()
    {
        return true;
    }

    public function actionCategory($name)
    {
        return $this->render('category');
    }

    public function actionSubCategory($sub)
    {
        return $this->render('category');
    }
}