<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => [
        'class' => false
    ]
]);
$status = [
        0 => 'Неактивен',
        10 => 'Активен'
];
?>
<div class="row">
    <div class="col-md-12">
        <div class="category-settings-tab">
            <div class="box-tab justified m-b-0">
                <div class="row">
                    <?= $form
                        ->field($model, 'username', [
                            'options' => [
                                'class' => 'form-group col-md-2',
                                'tag' => 'div',
                            ],
                        ])->label('Имя пользователя')
                        ->textInput(['maxlength' => true, ]) ?>
                </div>
                <div class="row">
                    <?= $form
                        ->field($model, 'email', [
                            'options' => [
                                'class' => 'form-group col-md-2',
                                'tag' => 'div'
                            ]
                        ])->label('E-mail')
                        ->textInput(['maxlength' => true]) ?>
                </div>
                <div class="row">
                    <?= $form
                        ->field($model, 'password', [
                            'options' => [
                                'class' => 'form-group col-md-2',
                                'tag' => 'div'
                            ]
                        ])->label('Пароль')
                        ->passwordInput(['maxlength' => true]) ?>
                </div>

                <?= $form->field($model, 'profileType', [
                    'options' => [
                        'class' => 'form-group col-md-2',
                        'tag' => 'div'
                    ]
                ] )
                    ->label(Yii::t('app', 'Роль пользователя'))
                    ->dropDownList($roles, ['prompt' => 'Выбрать статус...']) ?>
                <?= $form->field($model, 'status', [
                    'options' => [
                        'class' => 'form-group col-md-2',
                        'tag' => 'div'
                    ]
                ] )
                    ->label('Статус пользователя')
                    ->dropDownList($status, ['prompt' => 'Выбрать статус...']) ?>
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
