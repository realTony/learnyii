<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->label(false)->textInput(['autofocus' => true, 'placeholder' => 'Имя'])?>
        <?= $form->field($model, 'email')->label(false)->input('email', ['placeholder' => "E-Mail"]) ?>
        <?= $form->field($model, 'phone')->label(false)->input('phone', ['placeholder' => 'Телефон']) ?>
        <?= $form->field($model, 'city')->label(false)->textInput(['placeholder' => 'Город']) ?>
        <?= $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => 'Пароль']) ?>
		<?= $form->field($model, 'password_repeat')->label(false)->passwordInput(['placeholder' => 'Повторить пароль']) ?>
        <?= $form->field($model, 'rules_agreement')->label('Согласен с условиями использования')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div>
</div>

