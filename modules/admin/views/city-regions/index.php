<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CityRegionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'City Regions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-regions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create City Regions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'city_id',
            'region',
            'region_ua',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>