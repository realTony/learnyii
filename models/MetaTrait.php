<?php

namespace app\models;


use Yii;

trait MetaTrait
{
    /** @var object $model */
    private static $model;

    public static function setModel(object $model) : void
    {
        self::$model = $model;
    }

    public static function getMeta() : array
    {
        $model = self::$model;
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

        $model->options = json_decode($model->options);
        $model->translation = json_decode($model->translation);

        $metaData = [
            'ru' => [
                'title' => (! empty($model->title)) ? $model->title : '',
                'meta_description' => (! empty($model->options->seo_description)) ? $model->options->seo_description : '',
                'seo_title' => (! empty($model->seo_title)) ? $model->seo_title : '',
                'seo_text' => (! empty($model->seo_text)) ? $model->seo_text : '',
                'no_index' => (! empty($model->options->no_index)) ? $model->options->no_index : 0,
                'no_follow' => (! empty($model->options->no_follow)) ? $model->options->no_follow : 0,
            ],
            'uk' => [
                'title' => (! empty($model->translation->title)) ? $model->translation->title : '',
                'meta_description' => (! empty($model->translation->seo_description)) ? $model->translation->seo_description : '',
                'seo_title' => (! empty($model->translation->seo_title)) ? $model->translation->seo_title : '',
                'seo_text' => (! empty($model->translation->seo_text)) ? $model->seo_text : '',
                'no_index' => (! empty($model->translation->no_index)) ? $model->translation->no_index : 0,
                'no_follow' => (! empty($model->translation->no_follow)) ? $model->translation->no_follow : 0,
            ]
        ];
        $metaData = $metaData[$currentLang];
        $noIndex = '';

        if($metaData['no_index'] == 1) {
            $noIndex = 'noindex';
        }
        if($metaData['no_index'] == 1) {
            $noIndex .= ', nofollow';
        }

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $metaData['meta_description']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => $noIndex
        ]);
        Yii::$app->view->title = (empty($metaData['seo_title'])) ? $metaData['title'] : $metaData['seo_title'];

        return $metaData;
    }
}