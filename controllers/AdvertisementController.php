<?php


namespace app\controllers;


use app\models\AdvertisementFilter;
use app\models\AdvertisementPost;
use app\models\AdvertisementPostSearch;
use app\models\AdvSearch;
use app\models\Profile;
use app\modules\admin\models\Categories;
use yii\helpers\Url;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\User;

class AdvertisementController extends Controller
{

    public function actionIndex()
    {
        $model = new AdvertisementPost();
        $advCategories = new Categories();
        $asideFilter = new AdvertisementFilter();
        $searchModel = new AdvertisementPostSearch();
        $filter = new AdvSearch();
        $dataProvider = $searchModel->searchCat(Yii::$app->request->queryParams);

//        if(! empty(Yii::$app->request->queryParams)) {
            $requested = Yii::$app->request->queryParams;

            if(Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $requested  = array_merge($requested, $post );
                $asideFilter->minPrice = $requested['minPrice'];
                $asideFilter->maxPrice = $requested['maxPrice'];
                $asideFilter->minDistance = $requested['minDistance'];
                $asideFilter->maxDistance = $requested['maxDistance'];
                $asideFilter->stickingArea = $requested['stickingArea'];
            }

            $dataProvider = $searchModel->searchCat($requested);
//        }

        $breadcrumbs = ['label' => Yii::t('app', 'Все объявления')];

        $pages = new Pagination([
            'totalCount' => $dataProvider->getTotalCount(),
            'pageSize' => $dataProvider->getCount(),

        ]);
;

        return $this->render('index', [
            'models' => $dataProvider->getModels(),
            'filter' => $filter,
            'sideFilter' => $asideFilter,
            'pages' => $pages,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function actionUser($id)
    {
        $user = User::findOne(['id'=>$id]);
        $breadcrumbs = ['label' => Yii::t('app', 'Все объявления пользователя').' '.$user->username];
        $model = new AdvertisementPost();
        $searchModel = new AdvertisementPostSearch();
        $filter = new AdvSearch();
        $dataProvider = $searchModel->searchUser(Yii::$app->request->queryParams);

        if(! empty(Yii::$app->request->queryParams)) {
            $requested = Yii::$app->request->queryParams;
            $requested['user_id'] = $user->id;
            $dataProvider = $searchModel->searchUser($requested);
        }

        $pages = new Pagination([
            'totalCount' => $dataProvider->getTotalCount(),
            'pageSize' => $dataProvider->getCount(),

        ]);


        return $this->render('user', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $filter,
            'user' => $user,
            'models' => $dataProvider->getModels(),
            'pages' => $pages,
        ]);
    }

    /**
     * @param $name
     * @return string
     */
    public function actionCategory($name)
    {
        $model = new AdvertisementPost();
        $advCategories = new Categories();
        $filter = new AdvSearch();
        $asideFilter = new AdvertisementFilter();
        $searchModel = new AdvertisementPostSearch();
        $catId = $advCategories->find()->where(['like', 'link', 'advertisement/'.$name]) ->andWhere(['is_blog' => 0]) ->one();


        if(! empty(Yii::$app->request->queryParams)) {
            $requested = Yii::$app->request->queryParams;

            if(Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $requested  = array_merge($requested, $post );
                $asideFilter->minPrice = $requested['minPrice'];
                $asideFilter->maxPrice = $requested['maxPrice'];
                $asideFilter->minDistance = $requested['minDistance'];
                $asideFilter->maxDistance = $requested['maxDistance'];
                $asideFilter->stickingArea = $requested['stickingArea'];
            }

            $requested['category_id'] = $catId->id;
            $dataProvider = $searchModel->searchCat($requested);
        }


        $advPosts = $model;
        $breadcrumbs = [
            ['label' => Yii::t('app', 'Объявления'), 'url' => Url::to('/advertisement')],
            ['label' => Yii::t('app', $catId->title)]
        ];
//        $countQuery = clone $advPosts;
        $pages = new Pagination([
            'totalCount' => $dataProvider->getTotalCount(),
            'pageSize' => $dataProvider->getCount(),

        ]);


        return $this->render('category', [
            'models' => $dataProvider->getModels(),
            'filter' => $filter,
            'sideFilter' => $asideFilter,
            'pages' => $pages,
            'breadcrumbs' => $breadcrumbs,
            'catInfo' => $catId
        ]);
    }

    public function actionSubCategory($sub)
    {
        $model = new AdvertisementPost();
        $advCategories = new Categories();
        $filter = new AdvSearch();
        $asideFilter = new AdvertisementFilter();
        $searchModel = new AdvertisementPostSearch();
        $catId = $advCategories->find()->where(['like', 'link', $sub]) ->andWhere(['is_blog' => 0]) ->one();


        if(! empty(Yii::$app->request->queryParams)) {
            $requested = Yii::$app->request->queryParams;
            $requested['subCat_id'] = $catId->id;

            if(Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $requested  = array_merge($requested, $post );
                $asideFilter->minPrice = $requested['minPrice'];
                $asideFilter->maxPrice = $requested['maxPrice'];
                $asideFilter->minDistance = $requested['minDistance'];
                $asideFilter->maxDistance = $requested['maxDistance'];
                $asideFilter->stickingArea = $requested['stickingArea'];
            }

            $dataProvider = $searchModel->searchCat($requested);
        }

        $advCategories->parent = $catId->id;
        $parentCat = $advCategories->parents;
        foreach ($advCategories->children as $id => $title) {

            $advCategories->parent = $id;
            $parentCat = $advCategories->children;
        }
        $breadcrumbs = [
            ['label' => Yii::t('app', 'Объявления'), 'url' => Url::to('/advertisement')],
            ['label' => Yii::t('app', $parentCat->title), 'url' => Url::to('/'.$parentCat->link)],
            ['label' => Yii::t('app', $catId->title)]
        ];
//        $countQuery = clone $advPosts;
        $pages = new Pagination([
            'totalCount' => $dataProvider->getTotalCount(),
            'pageSize' => $dataProvider->getCount(),

        ]);


        return $this->render('category', [
            'models' => $dataProvider->getModels(),
            'filter' => $filter,
            'sideFilter' => $asideFilter,
            'pages' => $pages,
            'breadcrumbs' => $breadcrumbs,
            'catInfo' => $catId
        ]);
    }

    public function actionAdvertise($id)
    {
        $model = (new AdvertisementPost())->findOne($id);
        $user = (new User())->findOne($model->authorId);
        $profile = (new Profile())->findOne(['user_id' => $model->authorId]);
        $similar = (new AdvertisementPost())
            ->find()
            ->where(['subCat_id' => $model->subCat_id])
            ->andWhere(['not in', 'id', $id])
            ->orderBy('isPremium DESC, published_at DESC')
            ->limit(4)
            ->all();

        $breadcrumbs = ['label' => Yii::t('app', 'Объявления')];

        return $this->render('advertisement', [
            'model' => $model,
            'similar' => $similar,
            'user' => $user,
            'profile' => $profile,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}