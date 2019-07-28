<?php

use app\models\Profile;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use app\widgets\SearchAdverts;
use app\widgets\FooterInfo;
use app\widgets\UserBar;
use yii\helpers\Url;

echo SearchAdverts::widget();
?>
<script>
 window.deleteImage = "<?= Url::toRoute('/myaccount/default/remove-photo') ?>";
</script>
<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <?= \yii\widgets\Breadcrumbs::widget([
                'links' => $breadcrumbs,
                'options'=> [
                    'class' => 'bread-crumbs'
                ]
            ]) ?>
        </div>
    </div>
</div>
    <div class="container">
        <div class="title-text clone">
            <h1><?= $meta['title'] ?></h1>
        </div>
        <div class="group-content">
            <!-- User bar -->
            <?= UserBar::widget([
                'user' => $user
            ])?>
            <!-- end User bar -->
            <?php $form = ActiveForm::begin([
                'id' => 'edit-image-form',
                'action' => Url::toRoute('/myaccount/default/save-image'),
                'enableAjaxValidation' => false,
                'options' => [
                    'enctype' => 'multipart/form-data',
                ]
            ]); ?>
            <?= $form->field($uploadImage, 'imageFile')
                     ->label(false)
                     ->fileInput(); ?>
            <?php ActiveForm::end(); ?>
            <div class="content">
                <?php $form = ActiveForm::begin([
                    'id' => 'edit-profile-form',
                    'action' => '',
                    'options' => [
                        'class' => 'form-user',
                    ]
                ]); ?>
                <fieldset>
                    <div class="group">
                        <div class="holder-left">
                            <div class="holder-img" style="background: url('<?= Profile::getUserAvatar( Yii::$app->user->id) ?>') no-repeat center center; background-size:cover; ">
                                <img src="/images/avatar-holder.png">
                                <div class="edit-photo">
                                    <?php
                                    Modal::begin([
                                        'id' => 'photo-modal',
                                        'title'  => false,
                                        'footer' => Html::button(Yii::t('app', 'Cохранить'), [ 'id' => 'avatar_crop', 'class' => 'btn-orange']).
                                                    Html::button(Yii::t('app',
                                                'Отменить'),
                                                ['id' => 'avatar_cancel', 'class' => 'btn-orange'])
                                    ]);

                                    ?>
                                    <div class="img-container">
                                        <img id='avatar_big' src="">
                                    </div>
                                    <?php

                                    Modal::end();
                                    ?>
                                    <a href="#" id="save-photo">
                                        <i class="fas fa-pen-square"></i>
                                    </a>
                                    <a href="#" id="delete-photo">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="size-photo">
                                <span><?= Yii::t('app', 'Фото должно иметь разрешение не менее 210х210 пикселей')?></span>
                            </div>
                        </div>
                        <div class="holder-right">
                            <?= $form->field($model, 'username', ['options' => [
                                    'class' => 'holder-input',
                                    'tag' => 'div',
                            ]])->label(false)
                             ->textInput([
                                     'placeholder' => Yii::t('app', 'Имя'),
                                     'class' => 'input'
                             ]); ?>
                            <ul class="input-list">
                                <li>
                                <?= $form->field($model, 'email', ['options' => [
                                    'class' => 'holder-input',
                                    'tag' => false
                                ]])->label(false)
                                 ->input('email', [
                                     'placeholder' => Yii::t('app', 'E-Mail'),
                                     'class' => 'input'
                                 ]) ?>
                                </li>
                                <li>
                                    <?= $form->field($model, 'address',
                                        ['options' => ['tag' => false]])->label(false)
                                             ->textInput([
                                                 'placeholder' => Yii::t('app', 'Адрес'),
                                                 'class' => 'input'
                                             ]); ?>
                                </li>
                                <li>
                                    <?= $form->field($model, 'phone',
                                        [ 'options' => [ 'tag' => false ] ])->label(false)
                                        ->input('phone', [
                                            'placeholder' => Yii::t('app', 'Телефон'),
                                            'class' => 'input'
                                        ]) ?>
                                </li>
                                <li>
                                    <?= $form->field($model, 'viber', [
                                            'options' => [ 'tag' => false]])
                                             ->label(false)
                                             ->input('phone', [
                                                 'placeholder' => Yii::t('app', 'Viber'),
                                                 'class' => 'input']) ?>
                                </li>
                                <li>
                                    <?= $form->field($model, 'telegram', [
                                        'options' => [ 'tag' => false]])
                                             ->label(false)
                                             ->textInput([
                                                 'placeholder' => Yii::t('app', 'Telegram'),
                                                 'class' => 'input']) ?>
                                </li>
                                <li>
                                    <?= $form->field($model, 'whatsapp', [
                                        'options' => [ 'tag' => false]])
                                             ->label(false)
                                             ->input('phone', [
                                                 'placeholder' => Yii::t('app', 'Whatsapp'),
                                                 'class' => 'input']) ?>
                                </li>
                            </ul>
                            <ul class="input-button">
                                <div>
                                    <?= $form->field($model, 'site', [
                                        'options' => [ 'tag' => false]])
                                             ->label(false)
                                             ->textInput([
                                                 'placeholder' => Yii::t('app', 'Сайт'),
                                                 'class' => 'input']) ?>
                                </div>
                                <div>
                                    <?= Html::submitButton(Yii::t('app', 'Cохранить'), ['class' => 'btn-orange']) ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <hr>
                </fieldset>
                <?php ActiveForm::end(); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'change-password',
                    'action' => '',
                    'options' => [
                        'class' => 'form-user',
                    ]
                ]); ?>
                <fieldset>
                    <div class="group">
                        <div class="holder-left">
                            <h2><?= Yii::t('app', 'Изменить пароль') ?></h2>
                        </div>
                        <div class="holder-right">
                            <div class="holder-password">
                                <div class="holder-input">
                                    <?= $form->field($changePassword, 'oldPassword', [
                                        'options' => [
                                                'class' => 'holder-input',
                                                'tag' => 'div']])
                                             ->label(false)
                                             ->passwordInput([
                                                 'placeholder' => Yii::t('app', 'Старый пароль'),
                                                 'class' => 'input']) ?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($changePassword, 'newPassword', [
                                        'options' => [
                                            'class' => 'holder-input',
                                            'tag' => 'div']])
                                             ->label(false)
                                             ->passwordInput([
                                                 'placeholder' => Yii::t('app', 'Новый пароль'),
                                                 'class' => 'input']) ?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($changePassword, 'repeatNewPassword', [
                                        'options' => [
                                            'class' => 'holder-input',
                                            'tag' => 'div']])
                                             ->label(false)
                                             ->passwordInput([
                                                 'placeholder' => Yii::t('app', 'Повторите новый пароль'),
                                                 'class' => 'input']) ?>
                                </div>
                                <?= Html::submitButton(Yii::t('app', 'Изменить пароль'), ['class' => 'btn-orange']) ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <hr>
    <?= FooterInfo::widget([
        'options' => [
            'has_seo' => false
        ]
    ]) ?>
