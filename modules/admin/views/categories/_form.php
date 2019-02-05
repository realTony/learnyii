<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => false
    ]
]); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card bg-white m-b">
            <div class="card-block">

                <?= $form->
                field($model, 'title', [
                    'options' => [
                        'class' => 'form-group',
                        'tag' => 'div'
                    ]
                ])->textInput(['maxlength' => true]) ?>


                <?= $form->field($model, 'description', [
                    'options' => [
                        'class' => 'form-group',
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
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card bg-white m-b">
            <div class="card-block">

                <?= $form->field($model, 'parent_id', [
                    'options' => [
                        'class' => 'form-group',
                        'tag' => 'div'
                    ]
                ] )->dropDownList($data['catList'], ['prompt' => 'Выберите категорию...']) ?>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card bg-white m-b">
            <div class="card-block"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white m-b">
            <div class="card-block">

                <?= $form->field($model, 'seo_title', [
                    'options' => [
                        'class' => 'form-group',
                        'tag' => 'div'
                    ]
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'seo_text', [
                    'options' => [
                        'class' => 'form-group',
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
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

