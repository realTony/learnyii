<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => false
        ]
    ]); ?>
    <div class="row">

        <?= $form->
        field($model, 'title', [
            'options' => [
                'class' => 'col-md-4',
                'tag' => 'div'
            ]
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'parent_id', [
            'options' => [
                'class' => 'col-md-4',
                'tag' => 'div'
            ]
        ] )->dropDownList($data['catList'], ['prompt' => 'Выберите категорию...']) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'description', [
            'options' => [
                'class' => 'col-md-8',
                'tag' => 'div'
            ]
        ])->widget(TinyMce::className(), [
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

        <?= $form->field($model, 'seo_title', [
            'options' => [
                'class' => 'col-md-4',
                'tag' => 'div'
            ]
        ])->textInput(['maxlength' => true]) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'seo_text', [
            'options' => [
                'class' => 'col-md-8',
                'tag' => 'div'
            ]
        ])->widget(TinyMce::className(), [
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
