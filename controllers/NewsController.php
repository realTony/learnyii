<?php

namespace app\controllers;


use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\admin\models\Categories;
use app\modules\admin\models\BlogPosts;
use yii\web\NotFoundHttpException;

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

        if(empty($model)) {
            throw new NotFoundHttpException();
        }

        $options = (!empty($model->options)) ? json_decode($model->options, true) : [];
        $model->translation = (!empty($model->translation)) ? json_decode($model->translation, true) : [];
        $model->options = $options;
        $meta_data = [
            'ru' => [
                'title' => (! empty($model->title)) ? $model->title : '',
                'meta_description' => '',
                'seo_title' => (! empty($model->seo_title)) ? $model->seo_title : $model->title,
                'seo_text' => (! empty($model->seo_text)) ? $model->seo_text : '',
            ],
            'uk' => [
                'title' => (! empty($model->translation['title'])) ? $model->translation['title'] : $model->title,
                'meta_description' => '',
                'seo_title' => (! empty($model->translation['seo_title'])) ? $model->translation['seo_title'] : '',
                'seo_text' => ''
            ]
        ];

        $cat = (! empty($model->category_id) ) ?$model->category_id: false;

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $meta_data = $meta_data[$currentLang];
        $description = ($currentLang == 'uk' && !empty($model->translation['description'])) ? $model->translation['description'] : $model->description;
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
                'label' => $meta_data['title']
            ];
        }

        $this->getView()->title = (empty($meta_data['seo_title'])) ? $meta_data['title'] : $meta_data['seo_title'];
        $model->title = $meta_data['title'];

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

        if(empty($category)) {
            throw new NotFoundHttpException();
        }

        $options = (!empty($category->options)) ? json_decode($category->options, true) : [];
        $category->translation = (!empty($category->translation)) ? json_decode($category->translation, true) : [];

        $meta_data = [
            'ru' => [
                'title' => (! empty($category->title)) ? $category->title : '',
                'meta_description' => '',
                'seo_title' => (! empty($category->seo_title)) ? $category->seo_title : '',
                'seo_text' => (! empty($category->seo_text)) ? $category->seo_text : '',
            ],
            'uk' => [
                'title' => (! empty($category->translation['title'])) ? $category->translation['title'] : '',
                'meta_description' => '',
                'seo_title' => (! empty($category->translation['seo_title'])) ? $category->translation['seo_title'] : '',
                'seo_text' => ''
            ]
        ];
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $meta_data = $meta_data[$currentLang];

        $breadcrumbs = [
            [
                'label' => Yii::t('app', 'Новости'),
                'url' => '/news'
            ], [
                'label' => $meta_data['title'],
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


        $this->getView()->title = (empty($meta_data['seo_title'])) ? $meta_data['title'] : $meta_data['seo_title'];
        return $this->render('blog.php', [
            'categories' => $menuItems,
            'models' => $models,
            'pages' => $pages,
            'breadcrumbs' => $breadcrumbs]);
    }

}