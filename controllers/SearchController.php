<?php

namespace app\controllers;


use app\models\AdvertisementPost;
use app\models\AdvSearch;
use app\models\Settings;
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
        $pageTitle = Yii::t('app', 'Результаты поиска');
        $model = new SiteSearch();
        $dataRes = $model->search(Yii::$app->request->queryParams);
        $filter = new AdvSearch();
        $settings = Yii::createObject(Settings::className())
            ->findOne(['name' => 'search_settings']);
        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $metaData = [
            'ru' => [
                'title' => $pageTitle,
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $pageTitle,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : $pageTitle,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : $pageTitle,
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];
        $metaData = $metaData[$currentLang];

        $this->getView()->title = (empty($metaData['seo_title'])) ? $metaData['title'] : $metaData['seo_title'];

        $queriedItem = Yii::$app->request->queryParams;

        $countQuery = AdvertisementPost::find();

        $pages = new Pagination([
            'totalCount' => $dataRes->getTotalCount(),
            'pageSize' => 6,

        ]);

        $models = $dataRes->getModels();

        if( empty($models)) {
            $query = Yii::$app->request->queryParams;
            $query['textRequest'] = $query['textRequest']?: '';

            return $this->render('not-found', [
                'title' => $query['textRequest'],
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