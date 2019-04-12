<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => [
        'class' => false
    ]
]);
$icons = [
        'fa-crown' => 'Корона',
        'fa-angle-double-up' => 'Стрелочка вверх',
        'fa-briefcase' => 'Кейс',
];
?>
<div class="row">
    <div class="col-md-12">
        <div class="category-settings-tab">
            <div class="box-tab justified m-b-0">
                <div class="row">
                    <?= $form
                        ->field($model, 'rate', [
                            'options' => [
                                'class' => 'form-group col-md-6',
                                'tag' => 'div',
                            ],
                        ])->label(Yii::t('app', 'Название услуги'))
                        ->textInput(['maxlength' => true, ]) ?>

                    <?= $form
                        ->field($model, 'rate_ua', [
                            'options' => [
                                'class' => 'form-group col-md-6',
                                'tag' => 'div'
                            ]
                        ])->label(Yii::t('app', 'Название услуги Укр'))
                        ->textInput(['maxlength' => true]) ?>
                </div>
                <div class="row">
                    <?= $form
                        ->field($model, 'description', [
                            'options' => [
                                'class' => 'form-group col-md-6',
                                'tag' => 'div'
                            ]
                        ])->label(Yii::t('app', 'Описание услуги'))
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
                        ]) ?>

                    <?= $form
                        ->field($model, 'description_ua', [
                            'options' => [
                                'class' => 'form-group col-md-6',
                                'tag' => 'div'
                            ]
                        ])->label(Yii::t('app', 'Описание услуги Укр'))
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
                        ]) ?>
                </div>
                <div class="row">
                    <?= $form
                        ->field($model, 'price', [
                            'options' => [
                                'class' => 'form-group col-md-2',
                                'tag' => 'div'
                            ]
                        ])->label(Yii::t('app', 'Цена'))
                        ->textInput(['type' => 'number', 'min' => 0]) ?>
                    <?= $form->field($model, 'rate_icon', [
                        'options' => [
                            'class' => 'form-group col-md-2',
                            'tag' => 'div'
                        ]
                    ] )
                    ->label('Выбрать иконку')
                    ->dropDownList($icons, ['prompt' => 'Выбрать иконку...']) ?>

                </div>
                <div class="row">
                    <?= $form
                        ->field($model, 'duration', [
                            'options' => [
                                'class' => 'form-group col-md-2',
                                'tag' => 'div'
                            ]
                        ])->label(Yii::t('app', 'Длительность'))
                        ->textInput(['type' => 'number', 'min' => 1, 'placeholder' => Yii::t('app', 'Суток')]) ?>
                </div>
                <div class="row">
                    <?= $form
                        ->field($model, 'isTop', [
                            'options' => [
                                'class' => 'col-md-1',
                                'tag' => 'div'
                            ]
                        ])->label(Yii::t('app', 'Топ'))
                        ->checkbox([]) ?>
                    <?= $form
                        ->field($model, 'isUp', [
                            'options' => [
                                'class' => 'col-md-1',
                                'tag' => 'div'
                            ]
                        ])->label(Yii::t('app', 'Поднятие'))
                        ->checkbox([]) ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
</div>
<?php
ActiveForm::end();
?>
