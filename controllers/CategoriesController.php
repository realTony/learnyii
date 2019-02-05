<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 28.01.2019
 * Time: 1:03
 */

namespace app\controllers;

use app\modules\admin\models\Categories;
use Yii;
use yii\web\Controller;

class CategoriesController extends Controller
{

    public function actionIndex($link)
    {
        $model = new Categories();
        $res = $model->findOne(['link' => $link]);
        return 'test';
    }
}