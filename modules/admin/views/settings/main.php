<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-white m-b">
                <div class="card-header">
                    <h3>Настройки сайта</h3>
                </div>
                <div class="card-block">
                    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
                        <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
                            <?= Alert::widget([
                                'options' => ['class' => 'alert-dismissible alert-' . $type],
                                'body' => $message
                            ]) ?>
                        <?php endif ?>
                    <?php endforeach ?>
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'site_name')->label('Название сайта')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'site_email')->label('E-mail сайта')->input('email', ['maxlength' => true]) ?>
                    <?= $form->field($model, 'main_slider_max')->label('Максимальное количество слайдов на главной странице')->input('number', ['min' => 1, 'max' => 15]) ?>
                    <?= $form->field($model, 'advertisement_pageSize')->label('Количество объявлений на странице')->input('number', ['min' => 1]) ?>
                    <?= $form->field($model, 'vip_message_ru')->label('Текст премиум сообщения Рус')->textarea() ?>
                    <?= $form->field($model, 'vip_message_uk')->label('Текст премиум сообщения Укр')->textarea() ?>
                    <?= $form->field($model, 'site_telegram')->label('Telegram')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'site_facebook')->label('Facebook')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'site_viber')->label('Viber')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'site_instagram')->label('Instagram')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'liqpay_public_key')->label('Публичный ключ LiqPay')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'liqpay_private_key')->label('Приватный ключ LiqPay')->textInput(['maxlength' => true]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>