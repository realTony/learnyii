<?php

use app\widgets\FooterInfo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Categories;
use app\models\Cities;
use app\widgets\UserBar;

$categories = Yii::createObject(Categories::className());
$stickAreas = Yii::createObject(\app\models\StickingAreas::className());
$types = Yii::createObject(\app\models\AdvType::className());
$catList = $categories->advertisement;
$subList = $categories->subAdvertisement;
$areas  = $stickAreas->stickingAreas;
$types  =  $types->types;

?>
<?= \app\widgets\SearchAdverts::widget()?>
    <div class="holder-crumbs">
        <div class="container">
            <?= \yii\widgets\Breadcrumbs::widget([
                'links' => $breadcrumbs,
                'options'=> [
                    'class' => 'bread-crumbs'
                ]
            ]) ?>
        </div>
    </div>
    <div class="container">
        <div class="title-text clone">
            <h1>Создать объявление</h1>
        </div>
        <div class="group-content">
            <!-- User bar -->
            <?= UserBar::widget([
                'user' => $user
            ])?>
            <!-- end User bar -->
            <div class="content">
                <?php $form = ActiveForm::begin([
                    'id' => 'createPost',
                    'options' => [
                        'class' => 'form-user',
                        'enctype' => 'multipart/form-data'
                    ]
                ]); ?>
                <fieldset>
                    <?= $form->field($model, 'title', ['options' => ['class' => 'holder-input', 'tag' => 'div']])->label(false)
                        ->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Заголовок'), 'class' => 'input']) ?>
                    <ul class="input-list">

                        <?= $form->field($model, 'category_id', ['options' => ['class' => false, 'tag' => 'li']])
                            ->label(false)
                            ->dropDownList($catList, [
                                'class' => 'dropdown',
                                'id' => 'category_id',
                                'prompt' => Yii::t('app', 'Категория')

                            ]) ?>
                        <?= $form->field($model, 'subCat_id', ['options' => ['class' => false, 'tag' => 'li']])
                            ->label(false)
                            ->dropDownList($subList, ['class' => 'dropdown', 'id' => 'subcat_id', 'prompt' => Yii::t('app', 'Подкатегория') ]) ?>

                    </ul>
                    <hr>
                    <ul class="input-list">
                        <?= $form->field($model, 'sticking_area', ['options' => ['class' => false, 'tag' => 'li']])
                            ->label(false)
                            ->dropDownList($areas, ['class' => 'dropdown', 'prompt' => Yii::t('app', 'Область поклейки')]) ?>
                        <?= $form->field($model, 'distancePerMonth', ['options' => ['class' => false, 'tag' => 'li']])
                            ->label(false)
                            ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Пробег (км/мес)'), 'class' => 'input']) ?>
                        <?= $form->field($model, 'adv_type', ['options' => ['class' => false, 'tag' => 'li']])
                            ->label(false)
                            ->dropDownList($types, ['class' => 'dropdown', 'prompt' => Yii::t('app', 'Тип транспорта')]) ?>
                    </ul>
                    <ul class="input-list">
                        <?= $form->field($model, 'contract_term', ['options' => ['class' => false, 'tag' => 'li']])
                            ->label(false)
                            ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Срок договора (мес)'), 'class' => 'input']) ?>
                        <?= $form->field($model, 'pricePerMonth', ['options' => ['class' => false, 'tag' => 'li']])
                            ->label(false)
                            ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Цена (грн/мес)'), 'class' => 'input']) ?>
                        <li>
                            <?= $form->field($model, 'coverage_type', ['options' => ['class' => 'checkbox'], 'template' => '<label>{input}<span><i class="fas fa-check"></i>{label}</span></label>{error}'] )
                                ->label(Yii::t('app', 'Полная обклейка'))->checkbox([], false) ?>

                        </li>
                    </ul>
                    <hr>
                    <ul class="list-add-del">
                        <li>
                            <?= $form->field($model, 'city[]', ['options' => ['class' => 'holder-input', 'tag' => 'div']])
                                ->label(false)
                                ->textInput([ 'maxlength' => true, 'placeholder' => Yii::t('app', 'Город'), 'class' => 'input tags-city']) ?>
                            <?= $form->field($model, 'city_district[]',
                                ['options' => ['class' => 'holder-input', 'tag' => 'div'], 'template' => '<a class="btn-change add-input" href="#"></a>{input}{error}'])
                                ->label(false)
                                ->textInput([ 'maxlength' => true, 'placeholder' => Yii::t('app', 'Район'), 'class' => 'input']) ?>
                    </ul>
                    <hr>
                    <?= $form->field($model, 'description', ['options' => ['class' => 'holder-area', 'tag' => 'div']])
                        ->label(false)
                        ->textarea(['placeholder' => Yii::t('app', 'Описание')]) ?>
                    <hr>
                    <ul class="list-img">
                        <?php foreach ($model->imagesLinks as $image):?>
                            <li>
                                <a href="#" class="holder-img">
                                    <i class="fas fa-times-circle"></i>
                                    <img src="<?= $image ?>" alt="img">
                                </a>
                            </li>
                        <?php endforeach;?>
                        <li id="add-adv-image">
                            <div class="holder-file">
                                <?= $form->field($model, 'image_items[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
                                <a href="#"><img src="<?= Url::home(true)?>/images/bg-61.png" alt="img"></a>
                            </div>
                        </li>
                    </ul>
                    <hr>
                    <div class="form-user-bottom">
                        <?= $form->field($model, 'showEmail', ['options' => ['class' => 'checkbox'], 'template' => '<label>{input}<span><i class="fas fa-check"></i>{label}</span></label>{error}'] )
                            ->label(Yii::t('app', 'Показать электронную почту на странице объявления'))->checkbox([], false) ?>
                        <?= Html::submitButton(Yii::t('app', 'Cохранить'), ['class' => 'btn-orange']) ?>
                    </div>
                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?//= FooterInfo::widget(); ?>