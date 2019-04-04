<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Categories;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Cities;

$categories = Yii::createObject(Categories::className());
$stickAreas = Yii::createObject(\app\models\StickingAreas::className());
$types = Yii::createObject(\app\models\AdvType::className());
$catList = $categories->advertisement;
$subList = $categories->subAdvertisement;
$areas  = $stickAreas->stickingAreas;
$types  =  $types->types;
$catFilters = Yii::createObject(\app\models\AdvertisementCatFilters::className());
$filters = [];
?>
<!--
Sticking Area - sticking_area
*Advertisement Type (old stuff) adv_type
distancePerMonth
Contract term (contract_term)
Price (pricePerMonth)
Coverage type (coverage_type)
-->
<?php if( $model->category_id != '') : ?>

<?php
    $catFilters = $catFilters->find()
        ->where(['category_id' => $model->category_id])
        ->all();
    $filters = ArrayHelper::map($catFilters, 'id', 'filter_name');
?>
<ul class="input-list">
    <?php if( $model->category_id == 8) : ?>
    <?= $form->field($model, 'sticking_area', ['options' => ['class' => false, 'tag' => 'li']])
        ->label(false)
        ->dropDownList($filters, ['class' => 'dropdown', 'prompt' => Yii::t('app', 'Область поклейки')]) ?>
    <?php elseif( $model->category_id == 9): ?>
    <?= $form->field($model, 'adv_type', ['options' => ['class' => false, 'tag' => 'li']])
        ->label(false)
        ->dropDownList($filters, ['class' => 'dropdown', 'prompt' => Yii::t('app', 'Тип транспорта')]) ?>
    <?php endif; ?>
    <?= $form->field($model, 'distancePerMonth', ['options' => ['class' => false, 'tag' => 'li']])
        ->label(false)
        ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Пробег (км/мес)'), 'class' => 'input']) ?>

</ul>
<ul class="input-list">

    <?php if( $model->category_id == 8 || $model->category_id == 9) : ?>
    <?= $form->field($model, 'contract_term', ['options' => ['class' => false, 'tag' => 'li']])
        ->label(false)
        ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Срок договора (мес)'), 'class' => 'input']) ?>
    <?php endif; ?>
    <?= $form->field($model, 'pricePerMonth', ['options' => ['class' => false, 'tag' => 'li']])
        ->label(false)
        ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Цена (грн/мес)'), 'class' => 'input']) ?>
    <li>
        <?= $form->field($model, 'coverage_type', ['options' => ['class' => 'checkbox'], 'template' => '<label>{input}<span><i class="fas fa-check"></i>{label}</span></label>{error}'] )
            ->label(Yii::t('app', 'Полная обклейка'))->checkbox([], false) ?>

    </li>
</ul>
<hr>
<?php endif; ?>