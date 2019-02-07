<?php

use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
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
            <div class="card-header ">
                <h3 class="text-center m-b-md">Основные поля</h3>
            </div>
            <div class="card-block">
                <?= $form
                    ->field($model, 'title', [
                        'options' => [
                            'class' => 'form-group',
                            'tag' => 'div'
                        ]
                    ])->label('Название категории')
                    ->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'parent_id', [
                    'options' => [
                        'class' => 'form-group',
                        'tag' => 'div'
                    ]
                ] )->label('Выбрать родительскую категория')->dropDownList($data['catList'], ['prompt' => 'Выберите категорию...']) ?>

                <?= $form->field($model, 'description', [
                    'options' => [
                        'class' => 'form-group',
                        'tag' => 'div'
                    ]
                ])->label('Описание')->widget(TinyMce::className(), [
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
            <div class="card-header ">
                <h3 class="text-center m-b-md">Настройки SEO</h3>
            </div>
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

<div class="col-md-6">
    <div class="card bg-white m-b">
        <div class="card-header ">
            <h3 class="text-center m-b-md">Редактировать изображение категории</h3>
        </div>
        <div class="card-block">
            <?=
            FileInput::widget([
                'name' => 'Images[attachment]',
                'pluginOptions' => [
                    'deleteUrl' => Url::to(['categories/delete-image']),
                    'initialPreview'=> $model->imagesLinks,
                    'initialPreviewAsData' => true,
                    'overwriteInitial' => false,
                    'initialPreviewConfig' => $model->imagesLinksData,
                    'uploadUrl' => Url::to(['categories/save-image']),
                    'uploadExtraData' => [
                        'Images[module]' => $model->formName(),
                        'Images[item_id]' => $model->id
                    ],
                    'maxFileCount' => 1
                ],
                'pluginEvents' => [
                    'filesorted' => new \yii\web\JsExpression('function(event, params){
                                  $.post("'.Url::toRoute(["categories/sort-image","id"=>$model->id]).'",{sort: params});
                            }')
                ],
            ])
            ?>
        </div>
    </div>
</div>

