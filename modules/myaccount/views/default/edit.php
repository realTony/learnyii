<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use app\widgets\SearchAdverts;
use app\widgets\FooterInfo;

$this->title = Yii::t('app', 'Редактировать профиль');

echo SearchAdverts::widget();
?>

<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => $breadcrumbs,
                'options' => [
                    'class' => 'bread-crumbs'
                ]
            ])?>
        </div>
    </div>
</div>
<div class="container">
    <div class="title-text clone">
        <h1><?= $this->title ?></h1>
    </div>
    <div class="group-content">
        <div class="aside-left">
            <div class="aside-profile hide">
                <div class="seller clone">
                    <div class="holder-img">
                        <img src="{{ getAvatar(app.user.id) }}" alt="profile_image">
                    </div>
                    <div class="holder-text">
                        <a href="{{  url.toRoute('/myaccount/') }}" class="name">{{ user.username }}</a>
                        <span>{{ t('app', 'Дата регистрации') }}</span>
                        <span class="date">{{ user.created_at |date('d.m.Y') }}</span>
                    </div>
                </div>
                {% block myaccount_navbar %}
                {% include 'myaccount_navbar.twig' %}
                {% endblock %}
            </div>
        </div>

        {% set form = active_form_begin({
        'id': 'edit-image-form',
        'action' : url.toRoute('default/save-image'),
        'enableAjaxValidation': false,
        'options' : {
        'enctype' : 'multipart/form-data'
        }
        }) %}
        {{ form.field(uploadImage, 'imageFile').label(false).fileInput() | raw }}
        {{ active_form_end() }}
        <div class="content">
            {% set form = active_form_begin({
            'id': 'edit-profile-form',
            'action' : '',
            'options': {
            'class': 'form-user'
            }
            }) %}
            <fieldset>
                <div class="group">
                    <div class="holder-left">
                        <div class="holder-img">
                            <img src="{{ getAvatar(app.user.id) }}" alt="profile_image">
                            <div class="edit-photo">
                                <a href="#" id="save-photo">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                                <a href="#" id="delete-photo">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="size-photo">
                            <span>{{ t('app', 'Фото должно иметь размер не более 500 Кб и разрешение не менее 210х210 пикселей') }}</span>
                        </div>
                    </div>
                    <div class="holder-right">
                        {{ form
                        .field(model, 'username', {'options':{'class':'holder-input', 'tag':'div'}})
                        .label(false)
                        .textInput({'placeholder': t('app', 'Имя'), 'class':'input'}) | raw }}
                        <ul class="input-list">
                            <li>
                                {{ form
                                .field(model, 'email', {'options':{'tag':false}})
                                .label(false).input('email',{'placeholder':'E-Mail', 'class':'input'}) | raw }}
                            </li>
                            <li>
                                {{ form.
                                field(model, 'address', {'options':{'tag':false}})
                                .label(false).textInput({'placeholder': t('app', 'Адрес'), 'class':'input'}) | raw }}
                            </li>
                            <li>
                                {{ form.
                                field(model, 'phone', {'options':{'tag':false}}).
                                label(false).
                                input('phone', {'placeholder': t('app', 'Телефон'), 'class':'input'}) | raw }}
                            </li>
                            <li>
                                {{ form.
                                field(model, 'viber', {'options':{'tag':false}})
                                .label(false).input('phone',{'placeholder':'Viber', 'class':'input'}) | raw }}
                            </li>
                            <li>
                                {{ form.
                                field(model, 'telegram', {'options':{'tag':false}}).
                                label(false).textInput({'placeholder':'Telegram', 'class':'input'}) | raw }}
                                {#<input class="input" type="text" placeholder="Telegram">#}
                            </li>
                            <li>
                                {{ form
                                .field(model, 'whatsapp', {'options':{'tag':false}})
                                .label(false)
                                .input('phone',{'placeholder':'Whatsapp', 'class':'input'}) | raw }}
                            </li>
                        </ul>
                        <ul class="input-button">
                            <div>
                                {{ form
                                .field(model, 'site',{'options':{'tag':false}})
                                .label(false).textInput({'placeholder':'Сайт', 'class':'input'}) | raw }}
                            </div>
                            <div>
                                {{ submitButton(t('app','Сохранить'), {
                                'class': 'btn-orange',
                                }) | raw }}
                            </div>
                        </ul>
                    </div>
                </div>
                <hr>
            </fieldset>
            {{ active_form_end() }}
            {% set form = active_form_begin({
            'id': 'change-password',
            'action' : '',
            'options': {
            'class': 'form-user',
            }
            }) %}
            <fieldset>
                <div class="group">
                    <div class="holder-left">
                        <h2>{{ t('app', 'Изменить пароль') }}</h2>
                    </div>
                    <div class="holder-right">
                        <div class="holder-password">
                            <div class="holder-input">
                                {{ form
                                .field(changePassword, 'oldPassword', {'options':{'class':'holder-input', 'tag':'div'}})
                                .label(false).passwordInput({'placeholder':t('app', 'Старый пароль'), 'class':'input'}) | raw }}
                            </div>
                            <div class="holder-input">
                                {{ form
                                .field(changePassword, 'newPassword', {'options':{'class':'holder-input', 'tag':'div'}})
                                .label(false).
                                passwordInput({'placeholder':t('app', 'Новый пароль'), 'class':'input'}) | raw }}
                            </div>
                            <div class="holder-input">
                                {{ form
                                .field(changePassword, 'repeatNewPassword', {'options':{'class':'holder-input', 'tag':'div'}})
                                .label(false)
                                .passwordInput({'placeholder':t('app', 'Повторите новый пароль'), 'class':'input'}) | raw }}
                            </div>
                            {{ submitButton(t('app','Изменить пароль'), {
                            'class': 'btn-orange',
                            }) | raw }}
                        </div>
                    </div>
                </div>
            </fieldset>
            {{ active_form_end() }}
        </div>
    </div>
</div>
<hr>
{{ footer_info_widget() }}