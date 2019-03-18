<?php

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Categories */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\tinymce\TinyMce;

Yii::$app->params['bsVersion '] = '3.x';

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>

<div class="row">
    <div class="blog-settings-tab">
        <div class="box-tab justified m-b-0">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item active">
                    <a href="#rus"  data-toggle="tab" aria-expanded="true" aria-controls="ru"><?= Yii::t('app', 'Русский') ?></a>
                </li>
                <li class="nav-item">
                    <a href="#uk" data-toggle="tab" aria-expanded="false" aria-controls="uk"><?= Yii::t('app', 'Украинский') ?></a>
                </li>
            </ul>
            <div class="tab-content" id="translationTabs">
                <div class="tab-pane active" id="ru">
                    <div class="row create-form">
                        <div class="col-md-6">
                            <div class="card bg-white m-b">
                                <div class="card-header ">
                                    <h3 class="text-center m-b-md">Основные поля</h3>
                                </div>
                                <div class="card-block">
                                    <?= $form->field($model, 'title', [
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
                                    ])->textarea(['rows' => 6]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-white m-b">
                                <div class="card-block">
                                    <?= $form->field($model, 'category_id', [
                                        'options' => [
                                            'class' => 'form-group',
                                            'tag' => 'div'
                                        ]
                                    ])->dropDownList($categories, ['prompt' => 'Выберите категорию...']) ?>
                                    <?= $form->field($model, 'post_image')->
                                    widget(FileInput::classname(), [
                                        'options' => [
                                            'accept' => 'image/*',
                                        ],
                                        'pluginOptions' => [
                                            'initialPreview' =>     [
                                                $model->post_image? $model->post_image:''
                                            ],
                                            'initialPreviewAsData'=>true,
                                            'overwriteInitial' =>true,
                                            'showCaption' => false,
                                            'showUpload' => false,
                                            'showRemove' => false
                                        ],
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-white m-b">
                                <div class="card-header ">
                                    <h3 class="text-center m-b-md">Новость</h3>
                                </div>
                                <div class="card-block">
                                    <?= $form->field($model, 'options[content]', [
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
                </div>

                <div class="tab-pane" id="ua">
                    <div class="row create-form">
                        <div class="col-md-6">
                            <div class="card bg-white m-b">
                                <div class="card-block">
                                    <?= $form->field($model, 'translation[title]', [
                                        'options' => [
                                            'class' => 'form-group',
                                            'tag' => 'div'
                                        ]
                                    ])->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'translation[description]', [
                                        'options' => [
                                            'class' => 'form-group',
                                            'tag' => 'div'
                                        ]
                                    ])->textarea(['rows' => 6]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-white m-b">
                                <div class="card-block">
                                    <?= $form->field($model, 'translation[content]', [
                                        'options' => [
                                            'class' => 'form-group',
                                            'tag' => 'div'
                                        ]
                                    ])->label("Контент")->widget(TinyMce::className(), [
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
                                    <?= $form->field($model, 'translation[seo_title]', [
                                        'options' => [
                                            'class' => 'form-group',
                                            'tag' => 'div'
                                        ]
                                    ])
                                        ->label('SEO-заголовок')
                                        ->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'translation[seo_text]', [
                                        'options' => [
                                            'class' => 'form-group',
                                            'tag' => 'div'
                                        ]
                                    ])->label('SEO-текст')->widget(TinyMce::className(), [
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
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
