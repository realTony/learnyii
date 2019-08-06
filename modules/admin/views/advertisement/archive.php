<?php

use app\models\AdvertisementPostSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Автор',
                'value' => 'user.username',
            ],
            [
                'label' => 'E-mail',
                'value' => 'user.email',
            ],
            [
                'label' => 'Название',
                'value' => 'title',
            ],
            [
                'label' => 'Описание',
                'value' => 'description',
            ],
            'isPremium:boolean',
            'published_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{restore} {delete}',
                'buttons' => [
                    'restore' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-repeat"></span>',
                            $url,
                            [
                                'title' => Yii::t('app', 'Восстановить')
                            ]
                        );
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
