<?php

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */

use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use brussens\bootstrap\select\Widget as Select;

$this->title = 'Редактирование: Главная страница';
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="single-project-tab">
            <div class="box-tab justified m-b-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item active">
                        <a href="#rus"  data-toggle="tab" aria-expanded="true" aria-controls="ru">Русский</a>
                    </li>
                    <li class="nav-item">
                        <a href="#uk" data-toggle="tab" aria-expanded="false" aria-controls="uk">Украинский</a>
                    </li>
                </ul>
                <div class="tab-content" id="translationTabs">
                    <div class="tab-pane active" id="ru"><!--rus tab-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header ">
                                        <h3 class="text-center m-b-md">Основные настройки</h3>
                                    </div>
                                    <div class="card-block">
                                        <?= $form
                                            ->field($model, 'title')
                                            ->label('Заголовок страницы')
                                            ->textInput(['maxlength' => true]) ?>
                                        <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
                                        <?= $form->field($model, 'options[content]', [
                                            'options' => [
                                                'class' => 'form-group',
                                                'tag' => 'div'
                                            ]
                                        ])->label('Текст')
                                            ->widget(TinyMce::className(), [
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


                        <div class="seo-box card-header ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center m-b-md"><?= Yii::t('app', 'SEO Настройки')?></h3>
                                </div>
                            </div>
                            <div class="row seo-flex">
                                <div class="col-md-6">
                                    <div class="card bg-white m-b">
                                        <div class="card-block">
                                            <?= $form->field($model, 'seo_title')->label(Yii::t('app','Заголовок'))->textInput(['maxlength' => true]) ?>
                                            <?= $form->field($model, 'options[seo_description]')->label(Yii::t('app','Описание'))->textInput(['maxlength' => true]) ?>

                                            <?= $form->field($model, 'seo_text', [
                                                'options' => [
                                                    'class' => 'form-group',
                                                    'tag' => 'div'
                                                ]
                                            ])->label(Yii::t('app', 'SEO Текст'))
                                                ->widget(TinyMce::className(), [
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
                                            <div class="form-group seo-toggles">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h4><?= Yii::t('app', 'Добавить NO-INDEX')?></h4>
                                                    </div>
                                                    <?= $form->field($model, "options[no_index]", [
                                                        'options' => [
                                                            'tag' => 'div',
                                                            'class' => 'col-xs-6'
                                                        ],
                                                        'template' => '<label class="switch">{input}<span><i class="handle"></i></span></label>'
                                                    ])
                                                        ->checkbox([    'label' => false,
                                                            'type' => 'checkbox'
                                                        ]);

                                                    ?>
                                                </div>
                                            </div>
                                            <div class="form-group seo-toggles">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h4><?= Yii::t('app', 'Добавить NO-FOLLOW')?></h4>
                                                    </div>
                                                    <?= $form->field($model, "options[no_follow]", [
                                                        'options' => [
                                                            'tag' => 'div',
                                                            'class' => 'col-xs-6'
                                                        ],
                                                        'template' => '<label class="switch">{input}<span><i class="handle"></i></span></label>'
                                                    ])
                                                        ->checkbox([    'label' => false,
                                                            'type' => 'checkbox'
                                                        ]);

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!--end rus tab-->
                    <!--rus tab-->
                    <div class="tab-pane " id="uk">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header ">
                                        <h3 class="text-center m-b-md">Основные настройки</h3>
                                    </div>
                                    <div class="card-block">
                                        <?= $form
                                            ->field($model, 'translation[title]')
                                            ->label('Заголовок страницы')
                                            ->textInput(['maxlength' => true]) ?>
                                        <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
                                        <?= $form->field($model, 'translation[content]', [
                                            'options' => [
                                                'class' => 'form-group',
                                                'tag' => 'div'
                                            ]
                                        ])->label('Текст')
                                            ->widget(TinyMce::className(), [
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

                        <div class="seo-box card-header ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center m-b-md"><?= Yii::t('app', 'SEO Настройки')?></h3>
                                </div>
                            </div>
                            <div class="row seo-flex">
                                <div class="col-md-6">
                                    <div class="card bg-white m-b">
                                        <div class="card-block">
                                            <?= $form->field($model, 'translation[seo_title]')->label(Yii::t('app','Заголовок'))->textInput(['maxlength' => true]) ?>
                                            <?= $form->field($model, 'translation[seo_description]')->label(Yii::t('app','Описание'))->textInput(['maxlength' => true]) ?>

                                            <?= $form->field($model, 'translation[seo_text]', [
                                                'options' => [
                                                    'class' => 'form-group',
                                                    'tag' => 'div'
                                                ]
                                            ])->label(Yii::t('app', 'SEO Текст'))
                                                ->widget(TinyMce::className(), [
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
                                            <div class="form-group seo-toggles">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h4><?= Yii::t('app', 'Добавить NO-INDEX')?></h4>
                                                    </div>
                                                    <?= $form->field($model, "translation[no_index]", [
                                                        'options' => [
                                                            'tag' => 'div',
                                                            'class' => 'col-xs-6'
                                                        ],
                                                        'template' => '<label class="switch">{input}<span><i class="handle"></i></span></label>'
                                                    ])
                                                        ->checkbox([    'label' => false,
                                                            'type' => 'checkbox'
                                                        ]);

                                                    ?>
                                                </div>
                                            </div>
                                            <div class="form-group seo-toggles">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h4><?= Yii::t('app', 'Добавить NO-FOLLOW')?></h4>
                                                    </div>
                                                    <?= $form->field($model, "translation[no_follow]", [
                                                        'options' => [
                                                            'tag' => 'div',
                                                            'class' => 'col-xs-6'
                                                        ],
                                                        'template' => '<label class="switch">{input}<span><i class="handle"></i></span></label>'
                                                    ])
                                                        ->checkbox([    'label' => false,
                                                            'type' => 'checkbox'
                                                        ]);

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!--end uk tab-->

                </div><!--end ukr tab-->
            </div>
        </div>
    </div>

</div>

<?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
