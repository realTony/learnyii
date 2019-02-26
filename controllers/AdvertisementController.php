<?php


namespace app\controllers;


use app\models\AdvertisementPost;
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

        $advPosts = $model
            ->find();
        $breadcrumbs = ['label' => Yii::t('app', 'Все объявления')];
        $countQuery = clone $advPosts;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 9,

        ]);

        $models = $advPosts->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function actionUser($id)
    {
        $user = User::findOne(['id'=>$id]);
        $breadcrumbs = ['label' => Yii::t('app', 'Все объявления пользователя').' '.$user->username];
        $model = new AdvertisementPost();
        $advPosts = $model
            ->find()
            ->where(['authorId' => $user->id]);

        $countQuery = clone $advPosts;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,

        ]);
        $models = $advPosts->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('user', [
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'models' => $models,
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
        $catId = $advCategories->find()->where(['like', 'link', 'advertisement/'.$name]) ->andWhere(['is_blog' => 0]) ->one();

        $advPosts = $model
                    ->find()
                    ->where(['category_id' => $catId]);
        $breadcrumbs = [
            ['label' => Yii::t('app', 'Объявления'), 'url' => Url::to('/advertisement')],
            ['label' => Yii::t('app', $catId->title)]
        ];
        $countQuery = clone $advPosts;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 9,

        ]);
        $models = $advPosts->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('category', [
            'models' => $models,
            'pages' => $pages,
            'breadcrumbs' => $breadcrumbs,
            'catInfo' => $catId
        ]);
    }

    public function actionSubCategory($sub)
    {
        return $this->render('category');
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