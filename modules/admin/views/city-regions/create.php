<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CityRegions */

$this->title = 'Create City Regions';
$this->params['breadcrumbs'][] = ['label' => 'City Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-regions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>