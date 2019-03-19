<?php

namespace app\controllers;


use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\admin\models\Categories;
use app\modules\admin\models\BlogPosts;

class NewsController extends Controller
{
    public function filters()
    {
        return [
          'accessControl',
        ];
    }

    public function actionIndex() : string
    {
        $model = new Categories();
        $menuItems = $model->makeMenuList();
        $breadcrumbs = ['label' => Yii::t('app', 'Новости')];
        $posts = BlogPosts::find();
        $countQuery = clone $posts;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 9,

        ]);
        $models = $posts->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('blog.php', [
                'categories' => $menuItems,
                'models' => $models,
                'pages' => $pages,
                'breadcrumbs' => $breadcrumbs
            ]);
    }

    public function actionPost($link)
    {
        $model = BlogPosts::find()
            ->where(['link' => $link ])
            ->one();
        $cat = (! empty($model->category_id) ) ?$model->category_id: false;
        $options = (!empty($model->options))?json_decode($model->options, true):[];
        $model->options = (!empty($model->options))?json_decode($model->options, true):[];
        $translation = (!empty($model->translation))?json_decode($model->translation, true):[];
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $title = '';
        $description = '';
        $title = ($currentLang == 'uk' && !empty($translation['title'])) ? $translation['title'] : $model->title;
        $model->title = $title;
        $description = ($currentLang == 'uk' && !empty($translation['description'])) ? $translation['description'] : $model->description;
        $model->description = $description;

        $breadcrumbs[] = [
                        'label' => Yii::t('app', 'Новости'),
                        'url' => '/news'
        ];
        if ( empty($cat) || $cat === false) {
            unset($breadcrumbs[0]['url']);
        } else {
            $category = Yii::createObject(Categories::className() )
                ->find()
                ->where(['id' => $cat])
                ->one();
            $translation = (!empty($category->translation))? json_decode($category->translation, true): [];
            $breadcrumbs[] = [
                'label' => ($currentLang == 'uk' && ! empty($translation['title'])) ? $translation['title'] : $category->title,
                'url' => Url::to(['news/category/'.$category->link])
            ];
            $breadcrumbs[] = [
                'label' => $title
            ];
        }

        return $this->render('blog_post.php', [
            'model' => $model,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function actionCategory($link)
    {
        $model = new Categories();
        $menuItems = $model->makeMenuList();
        $category = $model->find()
            ->where(['link' => $link])
            ->one();

        $breadcrumbs = [
            [
                'label' => Yii::t('app', 'Новости'),
                'url' => '/news'
            ], [
                'label' => $category->title,
            ]
        ];

        $posts = BlogPosts::find()->where(['category_id' => $category->id]);
        $countQuery = clone $posts;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 9,

        ]);
        $models = $posts->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('blog.php', [
            'categories' => $menuItems,
            'models' => $models,
            'pages' => $pages,
            'breadcrumbs' => $breadcrumbs]);
    }

}