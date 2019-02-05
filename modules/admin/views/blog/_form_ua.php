<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Categories */
/* @var $form yii\widgets\ActiveForm */

use dosamigos\tinymce\TinyMce;
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
    <div class="row">
        <?= $form->field($model, 'translation[title]', [
            'options' => [
                'class' => 'col-md-4',
                'tag' => 'div'
            ]
        ])->label(Yii::t('app','Заголовок'))->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'category_id', [
            'options' => [
                'class' => 'col-md-4',
                'tag' => 'div'
            ]
        ])->dropDownList($categories, ['prompt' => 'Выберите категорию...']) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'translation[description]', [
            'options' => [
                'class' => 'col-md-6',
                'tag' => 'div'
            ]
        ])->label(Yii::t('app','Описание'))->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'post_image', [
            'options' => [
                'class' => 'col-md-6',
                'tag' => 'div'
            ]
        ])->fileInput() ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'translation[seo_title]', [
            'options' => [
                'class' => 'col-md-6',
                'tag' => 'div'
            ]
        ])->label(Yii::t('app','SEO-заголовок'))->textInput(['maxlength' => true]) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'translation[seo_text]', [
            'options' => [
                'class' => 'col-md-8',
                'tag' => 'div'
            ]
        ])->label(Yii::t('app','SEO-текст'))->widget(TinyMce::className(), [
            'options' => ['rows' => 6],
            'language' => 'ru',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);?>
    </div>
    <div class="row">
        <?= $form->field($model, 'translation[content]', [
            'options' => [
                'class' => 'col-md-8',
                'tag' => 'div'
            ]
        ])->label(Yii::t('app','Контент'))->widget(TinyMce::className(), [
            'options' => ['rows' => 6],
            'language' => 'ru',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
