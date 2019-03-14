<?php

namespace app\controllers;


use app\models\AdvertisementPost;
use app\models\AdvSearch;
use app\models\SiteSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use app\modules\admin\models\Categories;

class SearchController extends Controller
{

    public function actionIndex() : string
    {
        $breadcrumbs = ['label' => Yii::t('app', 'Результаты поиска')];

        $model = new SiteSearch();
        $dataRes = $model->search(Yii::$app->request->queryParams);
        $filter = new AdvSearch();


        $queriedItem = Yii::$app->request->queryParams;

        $countQuery = AdvertisementPost::find();

        $pages = new Pagination([
            'totalCount' => $dataRes->getTotalCount(),
            'pageSize' => 6,

        ]);

        $models = $dataRes->getModels();

        if( empty($models)) {
            return $this->render('not-found', [
                'title' => '',
                'breadcrumbs' => $breadcrumbs
            ]);
        }

        if (Yii::$app->request->isAjax && (Yii::$app->request->queryParams)['action'] == 'lazyLoad') {
            return $this->renderAjax('_loop', [
                'pages' => $pages,
                'model' => $models,
                'data' => $dataRes,
            ]);
        } else {

            return $this->render('results', [
                'title' => $queriedItem,
                'pages' => $pages,
                'model' => $models,
                'filter' => $filter,
                'data' => $dataRes,
                'breadcrumbs' => $breadcrumbs
            ]);
        }

    }

}