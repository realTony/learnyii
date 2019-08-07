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
$maxSlides = $settings['main_slider_max'] - count($model->imagesLinksData);
?>

<div class="page-title">
    <div class="title"><?= Html::encode($this->title) ?></div>
</div>
<!-- Slider -->
<div class="row">
    <div class="col-md-8">
        <div class="card bg-white m-b">
            <div class="card-header ">
                <h3 class="text-center m-b-md"><?= Yii::t('app', 'Редактировать слайдер')?></h3>
            </div>
            <div class="card-block">
                <?=
                FileInput::widget([
                    'name' => 'Images[attachment]',
                    'options'=>[
                        'multiple'=>true
                    ],
                    'pluginOptions' => [
                        'deleteUrl' => Url::to(['pages/delete-image']),
                        'initialPreview'=> $model->imagesLinks,
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => false,
                        'initialPreviewConfig' => $model->imagesLinksData,
                        'uploadUrl' => Url::toRoute(['pages/save-slide-image']),
                        'uploadExtraData' => [
                            'Images[module]' => $model->formName(),
                            'Images[item_id]' => $model->id
                        ],
                        'maxFileCount' => $maxSlides
                    ],
                    'pluginEvents' => [
                        'filesorted' => new \yii\web\JsExpression('function(event, params){
                                  $.post("'.Url::toRoute(["pages/sort-image","id"=>$model->id]).'",{sort: params});
                            }')
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Slider END -->
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header">
                                        <h3>Категории объявлений</h3>
                                    </div>
                                    <div class="card-block">
                                        <?php
                                        $i = 0;

                                        while ($i < 3) {
                                            echo $form->field($model, "options[categories][{$i}]")
                                                ->label(false)
                                                ->widget(Select::className(), [
                                                    'options' => [
                                                        'data-live-search' => false,
                                                        'maxOptions' => 4,
                                                    ],
                                                    'clientOptions' => [
                                                        'liveSearch' => false
                                                    ],
                                                    'items' => $model->advertList,
                                                ]);
                                            $i++;
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header ">
                                        <h3 class="text-center m-b-md">Редактировать "Как это работает"</h3>
                                    </div>
                                    <div class="card-block">
                                        <?= $form->field($model, 'options[how_it_works]', [
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
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header">
                                        <h3>Раздел новостей</h3>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <h4>Отображать блок на главной странице?</h4>
                                            </div>
                                            <?= $form->field($model, "options[is_promo]", [
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
                                        <?= $form->field($model, "options[promo][{$i}]")
                                            ->label(false)
                                            ->widget(Select::className(), [
                                                'options' => [
                                                    'data-live-search' => false,
                                                    'maxOptions' => 5,
                                                ],
                                                'clientOptions' => [
                                                    'liveSearch' => false
                                                ],
                                                'items' => $model->catList,
                                            ]);

                                        ?>
                                    </div>
                                    <div class="card-header">
                                        <h3><?= Yii::t('app', 'Раздел "Как это работает"')?></h3>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <h4>Отображать блок на главной странице?</h4>
                                            </div>
                                            <?= $form->field($model, "options[show_how_it_works]", [
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header">
                                        <h3>Категории объявлений</h3>
                                    </div>
                                    <div class="card-block">
                                        <?php
                                        $i = 0;

                                        while ($i < 3) {
                                            echo $form->field($model, "translation[categories][{$i}]")
                                                ->label(false)
                                                ->widget(Select::className(), [
                                                    'options' => [
                                                        'data-live-search' => false,
                                                        'maxOptions' => 4,
                                                    ],
                                                    'clientOptions' => [
                                                        'liveSearch' => false
                                                    ],
                                                    'items' => $model->advertList,
                                                ]);
                                            $i++;
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header ">
                                        <h3 class="text-center m-b-md">Редактировать "Как это работает"</h3>
                                    </div>
                                    <div class="card-block">
                                        <?= $form->field($model, 'translation[how_it_works]', [
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
                            <div class="col-md-6">
                                <div class="card bg-white m-b">
                                    <div class="card-header">
                                        <h3>Раздел новостей</h3>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <h4>Отображать блок на главной странице?</h4>
                                            </div>
                                            <?= $form->field($model, "translation[is_promo]", [
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
                                        <?= $form->field($model, "translation[promo][{$i}]")
                                            ->label(false)
                                            ->widget(Select::className(), [
                                                'options' => [
                                                    'data-live-search' => false,
                                                    'maxOptions' => 5,
                                                ],
                                                'clientOptions' => [
                                                    'liveSearch' => false
                                                ],
                                                'items' => $model->catList,
                                            ]);

                                        ?>
                                    </div>

                                    <div class="card-header">
                                        <h3><?= Yii::t('app', 'Раздел "Как это работает"')?></h3>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <h4>Отображать блок на главной странице?</h4>
                                            </div>
                                            <?= $form->field($model, "translation[show_how_it_works]", [
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
