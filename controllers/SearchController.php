<?php

namespace app\controllers;


use app\models\AdvertisementPost;
use app\models\AdvSearch;
use app\models\SiteSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;

class SearchController extends Controller
{

    public function actionIndex()
    {
        $breadcrumbs = ['label' => Yii::t('app', 'Результаты поиска')];

        $model = new SiteSearch();
        $dataRes = $model->search(Yii::$app->request->queryParams);
        $filter = new AdvSearch();


            $queriedItem = Yii::$app->request->queryParams;

            $countQuery = AdvertisementPost::find();

            $pages = new Pagination([
                'totalCount' => $countQuery->count(),
                'pageSize' => 6,

            ]);

            $models = $dataRes->getModels();

            return $this->render('results', [
                'title' => $queriedItem,
                'pages' => $pages,
                'model' => $models,
                'filter' => $filter,
                'breadcrumbs' => $breadcrumbs
            ]);

            return $this->render('not-found', [
                'title' => '',
                'breadcrumbs' => $breadcrumbs
            ]);
    }

}