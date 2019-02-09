<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!--    --><?php //// echo $this->render('_search', ['model' => $searchModel]); ?>
<!---->
<!--    <p>-->
<!--        --><?//= Html::a('Create Settings', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->
<!---->
<!--    --><?//= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'name',
//            'option_value:ntext',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>

    <div class="settings-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'option_value')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>