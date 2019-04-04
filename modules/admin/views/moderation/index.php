<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Пользователь',
                'value' => 'user.username',
            ],
            [
                'label' => 'E-mail',
                'value' => 'user.email',
            ],
            'title',
            [
                'label' => 'Категория',
                'value' => 'category.title',
            ],
            [
                'label' => 'Подкатегори',
                'value' => 'subCategory.title',
            ],
            'isPremium:boolean',
            'published_at:datetime',
//            'seo_text:ntext',
//            'seo_title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>