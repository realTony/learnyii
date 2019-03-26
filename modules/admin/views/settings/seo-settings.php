<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
$menu = Yii::$app->controller->getLabels();
?>
<div class="row">
    <div class="col-md-12">
        <!--card editor -->
        <div class="card">
            <div class="card-block p-a-0">
                <div class="box-tab single-project-tab justified m-b-0">
                    <ul class="nav nav-tabs">
                        <?php $i = 0; ?>
                        <?php foreach ($menu as $item => $label): ?>
                            <li <?php if( $i == 0 ):?>class="active"<?php endif; ?> >
                                <a href="#<?= $item ?>" data-toggle="tab"><?= $label ?></a>
                            </li>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                        <?php $i = 0; ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <?php foreach ( $menu as $name => $item ): ?>
                        <div class="tab-pane <?php if($i == 0): ?>active in<? endif;?>" id="<?= $name ?>"><!--header tab-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="single-project-tab">
                                        <div class="box-tab justified m-b-0">
                                            <div class="tab-content" id="translationTabs">
                                                <div class="tab-pane active" id="ru"><!--rus tab-->
                                                    <div class="seo-box card-header ">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h3 class="text-center m-b-md"><?= Yii::t('app', 'SEO Настройки')?></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="row seo-flex">
                                                            <div class="col-md-6">
                                                                <div class="card bg-white m-b">
                                                                    <div class="card-block">
                                                                        <?= $form->field($model, $name.'[options][seo_title]')->label(Yii::t('app','Заголовок Рус'))->textInput(['maxlength' => true]) ?>
                                                                        <?= $form->field($model, $name.'[translation][seo_title]')->label(Yii::t('app','Заголовок Укр'))->textInput(['maxlength' => true]) ?>
                                                                        <?= $form->field($model, $name.'[options][seo_description]')->label(Yii::t('app','Описание Рус'))->textInput(['maxlength' => true]) ?>
                                                                        <?= $form->field($model, $name.'[translation][seo_description]')->label(Yii::t('app','Описание Укр'))->textInput(['maxlength' => true]) ?>

                                                                        <?= $form->field($model, $name.'[options][seo_text]', [
                                                                            'options' => [
                                                                                'class' => 'form-group',
                                                                                'tag' => 'div'
                                                                            ]
                                                                        ])->label(Yii::t('app', 'SEO Текст Рус'))
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
                                                                        <?= $form->field($model, $name.'[translation][seo_text]', [
                                                                            'options' => [
                                                                                'class' => 'form-group',
                                                                                'tag' => 'div'
                                                                            ]
                                                                        ])->label(Yii::t('app', 'SEO Текст Укр'))
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
                                                                                <?= $form->field($model, $name."[options][no_index]", [
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
                                                                                <?= $form->field($model, $name."[options][no_follow]", [
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
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
<?php
ActiveForm::end();