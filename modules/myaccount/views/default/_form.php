<?php

use yii\widgets\ActiveForm;
use app\modules\admin\models\Categories;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Cities;
use yii\widgets\Pjax;

$categories = Yii::createObject(Categories::className());
$stickAreas = Yii::createObject(\app\models\StickingAreas::className());
$types = Yii::createObject(\app\models\AdvType::className());
$catList = $categories->advertisement;
$subList = $categories->subAdvertisement;
$areas  = $stickAreas->stickingAreas;
$types  =  $types->types;
$script = '';

ob_start(); ?>
    window.deletePath = "<?= Url::toRoute(['/myaccount/default/remove-adv-img']) ?>";
<?php
$script = ob_get_contents();
ob_end_clean();

$this->registerJs($script);
?>
<div class="content">
    <?php $form = ActiveForm::begin([
        'id' => 'createPost',
        'options' => [
            'class' => 'form-user',
            'enctype' => 'multipart/form-data',
            'data-catUrl' => Url::toRoute(['/myaccount/default/update-cat'])
        ]
    ]);
    ?>
    <fieldset>
        <!-- Post main fields start -->
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
        <!-- Post main fields end's here -->
        <?php Pjax::begin([
            'enablePushState' => false,
            'timeout' => false,
            'id' => 'filters'
        ])?>
        <img class="hidden loader" src="<?= Url::base(true) ?>/images/loader.svg" />
        <hr>
        <!-- Post filters start -->
        <?= $this->render('_filters', [
                'form' => $form,
                'model' => $model,
        ]) ?>
        <!-- Post filters end's here -->
        <?php Pjax::end(); ?>
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
            <?php foreach ($model->images as $image):
                    if( strpos($image->image_name, 'thumbnail')) {
                        continue;
                    }
                ?>
                <li>
                    <a href="#" class="holder-img" style="background: url('<?= $image->image_name ?>') no-repeat center center; background-size: cover;">
                        <i class="fas fa-times-circle delete-adv-image" data-id="<?= $image->id ?>"></i>
                        <img src="/images/edit_image.png" alt="img">
                    </a>
                </li>
            <?php endforeach;?>
            <li id="add-adv-image">
                <div class="holder-file">
                    <?= $form->field($model, 'image_items[]')->fileInput([ 'accept' => 'image/*']); ?>
                    <a href="#" id="add_adv_img"><img src="<?= Url::home(true)?>/images/bg-61.png" alt="img"></a>
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