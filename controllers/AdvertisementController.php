<?php


namespace app\controllers;


use app\components\L10nTrait;
use app\models\AdvertisementFilter;
use app\models\AdvertisementPost;
use app\models\AdvertisementPostSearch;
use app\models\AdvSearch;
use app\models\MetaTrait;
use app\models\Profile;
use app\models\Settings;
use app\modules\admin\models\Categories;
use yii\helpers\Url;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\User;
use yii\web\NotFoundHttpException;

class AdvertisementController extends Controller
{
    private $pageSize;
    use MetaTrait;
    use L10nTrait;

    public function beforeAction($action)
    {
        $this->pageSize = Yii::$app->params['pageSize'];

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Main advertisement page controller
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex() : string
    {

        if (Yii::$app->request->isAjax && (Yii::$app->request->queryParams)['action'] == 'lazyLoad') {
            return $this->loadPosts();
        }

        $model = new AdvertisementPost();
        $asideFilter = new AdvertisementFilter();
        $searchModel = new AdvertisementPostSearch();
        $filter = new AdvSearch();

        $settings = (Yii::createObject(Settings::className()))
            ->find()
            ->where(['name' => 'advertisement_settings'])
            ->one();

        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];

        $metaData = [
            'ru' => [
                'title' => (! empty($model->title)) ? $model->title : '',
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $model->title,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : $model->title,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : '',
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];
        $metaData = $metaData[$this->getLanguage()];
        $requested = Yii::$app->request->queryParams;

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $requested  = array_merge($requested, $post );
            $asideFilter->setProperties($requested);
        }

        $filter->orderBy = (!empty($requested['orderBy'])) ? $requested['orderBy'] : 'price_asc';
        $filter->city = (!empty($requested['city'])) ? $requested['city'] : '';
        $filter->district = (!empty($requested['district'])) ? $requested['district'] : '';

        $dataProvider = $searchModel->searchCat($requested);
        $premiumProvider = $searchModel->searchPremCat($requested);


        $breadcrumbs = ['label' => Yii::t('app', 'Все объявления')];

        $pages = new Pagination([
            'totalCount' => $dataProvider->getTotalCount(),
            'pageSize' => $this->pageSize

        ]);
        $this->getView()->title = (empty($metaData['seo_title'])) ? $metaData['title'] : $metaData['seo_title'];

        return $this->render('index', [
            'models' => $dataProvider->getModels(),
            'premium' => $premiumProvider->getModels(),
            'filter' => $filter,
            'sideFilter' => $asideFilter,
            'pages' => $pages,
            'data' => $dataProvider,
            'breadcrumbs' => $breadcrumbs
        ]);
    }


    /**
     * @param $name
     *
     * @return string
     * @throws NotFoundHttpException*@throws \ReflectionException
     */
    public function actionCategory($name) : string
    {
        /**
         * What the fuck is $filter var ?
         * @var  $asideFilter - sidebar filter which data I can get by POST?
         * fucking faggot
         *
         */
        $model = new AdvertisementPost();
        $advCategories = new Categories();
        $filter = new AdvSearch();
        $asideFilter = new AdvertisementFilter();
        $searchModel = new AdvertisementPostSearch();
        $path = str_replace($name.'/', $name, Yii::$app->request->pathInfo);
        $catId = $advCategories->find()->where([ 'link' => $path]) ->andWhere(['is_blog' => 0]) ->one();

        if(empty($catId)) {
            throw new NotFoundHttpException();
        }

        $catId->options = ($this->getLanguage() == 'uk') ?
            $catId->translation : $catId->options ;
        $this->setMetaData($catId);
        $meta = $this->getMetaData();

        if (Yii::$app->request->isAjax && (Yii::$app->request->queryParams)['action'] == 'lazyLoad') {

            $searchModel = new AdvertisementPostSearch();
            $requested = Yii::$app->request->queryParams;
            $requested['category_id'] = $catId->id;
            $default = get_object_vars($asideFilter);

            foreach ($requested as $filter=>$value) {
                if(isset($default[$filter]) && $default[$filter] == $value) {
                    unset($requested[$filter]);
                }
            }

            $asideFilter->setProperties($requested);
            $dataProvider = $searchModel->searchCat($requested);

            return $this->ajaxLoop($dataProvider);

        } else {

            $requested = Yii::$app->request->queryParams;
            $asideFilter->setProperties($requested);

            if(!empty($requested['orderBy'])) {
                $filter->orderBy =  $requested['orderBy'];
            }

            $filter->city = (!empty($requested['city'])) ? $requested['city'] : '';
            $filter->district = (!empty($requested['district'])) ? $requested['district'] : '';
            $requested['category_id'] = $catId->id;
            $dataProvider = $searchModel->searchCat($requested);

            $premiumProvider = $searchModel->searchPremCat($requested);
            $breadcrumbs = [['label' => Yii::t('app', 'Объявления')],];
            $pages = new Pagination([
                'totalCount' => $dataProvider->getTotalCount(),
                'pageSize' => $this->pageSize,

            ]);

            return $this->render('category', [
                'models' => $dataProvider->getModels(),
                'premium' => $premiumProvider->getModels(),
                'filter' => $filter,
                'sideFilter' => $asideFilter,
                'pages' => $pages,
                'data' => $dataProvider,
                'breadcrumbs' => $breadcrumbs,
                'catInfo' => $catId
            ]);
        }
    }

    /**
     * @param $sub
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSubCategory($sub) : string
    {
        $model = new AdvertisementPost();
        $advCategories = new Categories();
        $filter = new AdvSearch();
        $asideFilter = new AdvertisementFilter();
        $searchModel = new AdvertisementPostSearch();
        $path = str_replace($sub.'/', $sub, Yii::$app->request->pathInfo);
        $catId = $advCategories->find()->where([ 'link' => $path]) ->andWhere(['is_blog' => 0]) ->one();

        //404 if subcategory is not exists
        if(empty($catId)) {
            throw new NotFoundHttpException();
        }

        $metaData = $catId->meta;

        if (Yii::$app->request->isAjax && (Yii::$app->request->queryParams)['action'] == 'lazyLoad') {

            $requested = Yii::$app->request->queryParams;

            $requested['subCat_id'] = $catId->id;
            $requested['per-page'] = 29;
            $asideFilter->setProperties($requested);

            if(!empty($requested['orderBy'])) {
                $filter->orderBy =  $requested['orderBy'];
            }

            if(!empty($requested['extraFilter'])) {
                $filter->extraFilter =  $requested['extraFilter'];
            }
            $filter->city = (!empty($requested['city'])) ? $requested['city'] : '';
            $filter->district = (!empty($requested['district'])) ? $requested['district'] : '';

            $dataProvider = $searchModel->searchCat($requested);


            return $this->ajaxLoop($dataProvider);

        } else {

            $requested = Yii::$app->request->queryParams;
            $requested['subCat_id'] = $catId->id;
            $requested['per-page'] = 29;

            $asideFilter->setProperties($requested);

            if(!empty($requested['orderBy'])) {
                $filter->orderBy =  $requested['orderBy'];
            }
            if(!empty($requested['extraFilter'])) {
                $asideFilter->extraFilter =  $requested['extraFilter'];
            }

            $filter->city = (!empty($requested['city'])) ? $requested['city'] : '';
            $filter->district = (!empty($requested['district'])) ? $requested['district'] : '';

            $dataProvider = $searchModel->searchCat($requested);
            $premiumProvider = $searchModel->searchPremCat($requested);
            $advCategories->parent = $catId->id;
            $parentCat = $advCategories->parents;

            foreach ($advCategories->children as $id => $title) {
                $advCategories->parent = $id;
                $parentCat = $advCategories->children;
            }

            $breadcrumbs = [
                ['label' => Yii::t('app', 'Объявления'), 'url' => Url::to('/advertisement')],
                ['label' => Yii::t('app', $parentCat->meta['title'])],
            ];

            $catId->title = $catId->meta['title'];
            $this->getView()->title = (empty($metaData['seo_title'])) ? ($metaData['title'])?:$catId->title : $metaData['seo_title'];

            $pages = new Pagination([
                'totalCount' => $dataProvider->getTotalCount(),
                'pageSize' => $this->pageSize,

            ]);


            return $this->render('category', [
                'models' => $dataProvider->getModels(),
                'premium' => $premiumProvider->getModels(),
                'filter' => $filter,
                'sideFilter' => $asideFilter,
                'pages' => $pages,
                'data' => $dataProvider,
                'breadcrumbs' => $breadcrumbs,
                'catInfo' => $catId
            ]);
        }
    }

    public function actionUser($id)
    {
        $user = User::findOne(['id'=>$id]);
        $breadcrumbs = ['label' => Yii::t('app', 'Все объявления пользователя').' '.$user->username];
        $model = new AdvertisementPost();
        $searchModel = new AdvertisementPostSearch();
        $filter = new AdvSearch();
        $asideFilter = new AdvertisementFilter();
        $settings = Yii::createObject(Settings::className())
            ->findOne(['name' => 'user_advertisement']);
        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];
        $metaData = [
            'ru' => [
                'title' => (! empty($model->title)) ? $model->title : '',
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $model->title,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : $model->title,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : '',
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];
        $metaData = $metaData[$this->getLanguage()];
        $metaData['seo_title'] = str_replace('{user}', $user->username, $metaData['seo_title']);
        Yii::$app->getView()->title = $metaData['seo_title'];

        if (Yii::$app->request->isAjax && (Yii::$app->request->queryParams)['action'] == 'lazyLoad') {
            $requested = Yii::$app->request->queryParams;
            $requested['user_id'] = $id;
            $asideFilter->setProperties($requested);

            if(!empty($requested['orderBy'])) {
                $filter->orderBy =  $requested['orderBy'];
            }

            $filter->city = (!empty($requested['city'])) ? $requested['city'] : '';
            $filter->district = (!empty($requested['district'])) ? $requested['district'] : '';

            $dataProvider = $searchModel->searchUser($requested);


            return $this->ajaxLoop($dataProvider);

        } else {

            $requested = Yii::$app->request->queryParams;
            $requested['user_id'] = $id;
            if (!empty(Yii::$app->request->queryParams)) {
                $asideFilter->setProperties($requested);

                if(!empty($requested['orderBy'])) {
                    $filter->orderBy =  $requested['orderBy'];
                }

                $filter->orderBy = (!empty($requested['orderBy'])) ? $requested['orderBy'] : 'price_asc';
                $filter->city = (!empty($requested['city'])) ? $requested['city'] : '';
                $filter->district = (!empty($requested['district'])) ? $requested['district'] : '';

            }

            $dataProvider = $searchModel->searchUser($requested);

            $pages = new Pagination([
                'totalCount' => $dataProvider->getTotalCount(),
                'pageSize' => $this->pageSize,
                'pageSizeLimit' => $this->pageSize

            ]);


            return $this->render('user', [
                'breadcrumbs' => $breadcrumbs,
                'filter' => $filter,
                'sideFilter' => $asideFilter,
                'user' => $user,
                'data' => $dataProvider,
                'models' => $dataProvider->getModels(),
                'pages' => $pages,
            ]);
        }
    }


    public function actionAdvertise($id)
    {
        $model = (new AdvertisementPost())->findOne($id);
        $category = (new Categories())->findOne($model->category_id);
        $subCategory = (new Categories())->findOne($model->subCat_id);
        $user = (new User())->findOne($model->authorId);
        $profile = (new Profile())->findOne(['user_id' => $model->authorId]);
        /*Piece of hardcode*/
        $recommendedCat = [
            8 => 9,
            9 => 8,
            10 => 10
        ];

        $similar = (new AdvertisementPost())
            ->find()
            ->where(['category_id' => $recommendedCat[$model->category_id], 'is_approved' => 1, 'is_archived' => 0, 'is_banned' => 0])
            ->andWhere(['not in', 'id', $id])
            ->orderBy('isPremium DESC, published_at DESC')
            ->limit(4)
            ->all();
        $settings = Yii::createObject(Settings::className())
            ->findOne(['name' => 'inner_advertisement']);
        $settings = !empty($settings->option_value)? json_decode($settings->option_value, true): [];
        $metaData = [
            'ru' => [
                'title' => (! empty($model->title)) ? $model->title : '',
                'meta_description' => (! empty($settings['options']['meta_description'])) ? $settings['options']['meta_description'] : '',
                'seo_title' => (! empty($settings['options']['seo_title'])) ? $settings['options']['seo_title'] : $model->title,
                'seo_text' => (! empty($settings['options']['seo_text'])) ? $settings['options']['seo_text'] : '',
            ],
            'uk' => [
                'title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : $model->title,
                'meta_description' => (! empty($settings['translation']['meta_description'])) ? $settings['translation']['meta_description'] : '',
                'seo_title' => (! empty($settings['translation']['seo_title'])) ? $settings['translation']['seo_title'] : '',
                'seo_text' => (! empty($settings['translation']['seo_text'])) ? $settings['translation']['seo_text'] : '',
            ]
        ];
        $metaData = $metaData[$this->getLanguage()];
        $breadcrumbs = [
            ['label' => Yii::t('app', $category->meta['title']), 'url' => Url::to([$category->link])],
            ['label' => Yii::t('app', $subCategory->meta['title']), 'url' => Url::to([$subCategory->link])],
            ['label' => Yii::t('app', $model->title)]
        ];

        if( Yii::$app->user->isGuest || Yii::$app->user->id != $model->authorId ) {
            $model->updateViews($id);
        }
        $metaData['seo_title'] = str_replace('{title}', $model->title, $metaData['seo_title']);
        $metaData['title'] = str_replace('{title}', $model->title, $metaData['title']);
        $this->getView()->title = (empty($metaData['seo_title'])) ? $metaData['title'] : $metaData['seo_title'];

        return $this->render('advertisement', [
            'model' => $model,
            'similar' => $similar,
            'user' => $user,
            'profile' => $profile,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function ajaxLoop($dataProvider)
    {

        $pages = new Pagination([
            'totalCount' => $dataProvider->getTotalCount(),
            'pageSize' => $this->pageSize,

        ]);


        return $this->renderAjax('_loop', [
            'models' => $dataProvider->getModels(),
            'pages' => $pages,
            'data' => $dataProvider,
        ]);
    }

    private function loadPosts()
    {
        $asideFilter = new AdvertisementFilter();
        $searchModel = new AdvertisementPostSearch();
        $requested = Yii::$app->request->queryParams;

        if(Yii::$app->request->isGet) {
            $requested  = array_merge($requested, Yii::$app->request->get() );
            $asideFilter->setProperties($requested);
        }

        $dataProvider = $searchModel->searchCat($requested);

        return $this->ajaxLoop($dataProvider);
    }
}