<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegisterForm */
/* @var $loginModel \app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="form-search">
    <div class="container">
        <a class="search-query" href="#">Поисковый запрос</a>
        <div class="holder-form-search">
            <span class="bg-search"></span>
            <form>
                <fieldset>
                    <a class="closed-search-form" href="#"></a>
                    <div class="search-input">
                        <input type="text" placeholder="Поисковый запрос">
                    </div>
                    <div class="category-input">
                        <select name="dropdown" class="dropdown">
                            <option>Категория</option>
                            <option>Категория1</option>
                            <option>Категория2</option>
                            <option>Категория3</option>
                        </select>
                    </div>
                    <div class="city-input ui-widget">
                        <input class="tags-city" type="text" placeholder="Город">
                    </div>
                    <input class="btn-search" type="submit" value="искать">
                </fieldset>
            </form>
        </div>
    </div>
</div>
<div class="promo-block" style="background-image: url(images/bg-51.png)">
    <div class="container">
        <div class="login-registration">
            <div class="tabset">
                <ul class="tab-control">
                    <li class="active">
                        <a href="#">вход</a>
                    </li>
                    <li>
                        <a href="#">регистрация</a>
                    </li>
                </ul>
                <div class="tab-body">
                    <div class="tab active">
                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form'
                        ]); ?>
                            <fieldset>
                                <div class="holder-input">
                                    <?= $form->field($loginModel, 'login')
                                        ->label(false)
                                        ->textInput(['autofocus' => true, 'placeholder' => 'E-Mail']) ?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($loginModel, 'password')
                                        ->label(false)
                                        ->passwordInput(['placeholder' => 'Пароль']) ?>
                                </div>
                                <div class="holder-checkbox">
                                    <?= $form->field($loginModel, 'rememberMe', [
                                        'template' => "<label>{input}<span><i class=\"fas fa-check\"></i> Запомнить меня</span></label>",
                                    ])
                                        ->label(false)
                                        ->checkbox([],false) ?>
                                </div>
                                <?= Html::submitButton('войти', ['class' => 'btn-orange', 'name' => 'login-button']) ?>
                                <a class="forgot" href="#">Забыли пароль?</a>
                                <div class="in-network">
                                    <a class="btn-network" href="#">
                                        <div class="holder-img">
                                            <img src="images/bg-53.png" alt="img">
                                        </div>
                                        <span>Войти через Facebook</span>
                                    </a>
                                    <a class="btn-network" href="#">
                                        <div class="holder-img">
                                            <img src="images/bg-54.png" alt="img">
                                        </div>
                                        <span>Войти через Google</span>
                                    </a>
                                </div>
                            </fieldset>
                        <?php ActiveForm::end(); ?>
                        <form class="form-recovery">
                            <fieldset>
                                <span class="title">Восстановление пароля</span>
                                <div class="holder-input">
                                    <input type="text" placeholder="Введите ваш E-Mail">
                                </div>
                                <p class="left-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum in eros ex. Aliquam dignissim mauris vel sem imperdiet dictum. Ut fringilla, augue quis viverra pulvinar, dui odio varius nisi, eu aliquam elit nisl vulputate nunc. Quisque blandit egestas tortor id bibendum. Maecenas quis ante vel tortor mattis bibendum nec id sapien. Nam pulvinar arcu in interdum laoreet. Donec lacus ipsum, efficitur id mauris auctor, gravida tincidunt odio.</p>
                                <a class="btn-orange" href="#">восстановить</a>
                            </fieldset>
                        </form>
                    </div>
                    <div class="tab">
                        <?php $form = ActiveForm::begin([
                            'id' => 'register-form'
                        ]); ?>
                            <fieldset>
                                <div class="holder-input">
                                    <?= $form->field($model, 'username')->label(false)->textInput(['autofocus' => true, 'placeholder' => 'Имя'])?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($model, 'email')->label(false)->input('email', ['placeholder' => "E-Mail"]) ?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($model, 'phone')->label(false)->input('phone', ['placeholder' => 'Телефон']) ?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($model, 'city')->label(false)->textInput(['placeholder' => 'Город']) ?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => 'Пароль']) ?>
                                </div>
                                <div class="holder-input">
                                    <?= $form->field($model, 'password_repeat')->label(false)->passwordInput(['placeholder' => 'Повторить пароль']) ?>
                                </div>
                                <div class="holder-checkbox left-text">
                                    <?= $form->field($model, 'rules_agreement', [
                                        'template' => "<label>{input}<span><i class=\"fas fa-check\"></i>Согласен с <a href=\"#\">условиями использования</a></span>\n<div class=\"col-lg-8\">{error}</div></label>",
                                    ])->label(false)->checkbox([],false) ?>
<!--                                    <label for="c2">-->
<!--                                        <input id="c2" type="checkbox" name="c" checked>-->
<!--                                        <span><i class="fas fa-check"></i> Согласен с <a href="#">условиями использования</a></span>-->
<!--                                    </label>-->
                                </div>

                                <?= Html::submitButton('зарегистрироваться', ['class' => 'btn-orange', 'name' => 'register-button', 'value' => 'зарегистрироваться']) ?>
                            </fieldset>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="accordion">
    <div class="holder-section">
        <div class="container">
            <div class="holder-box-hidden clone">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut nunc in eros posuere euismod in a tortor. Phasellus nunc orci, vehicula in <span class="box-hidden">hendrerit eu, hendrerit quis neque. Duis eget turpis nec enim vulputate tristique vel vel sem. Etiam sagittis facilisis nisl, id ultricies ante commodo vitae. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer nec elit sollicitudin, vehicula massa vel, accumsan dolor. Phasellus placerat quam justo, eu porttitor ante imperdiet a. Duis imperdiet, lacus at placerat bibendum, lacus arcu molestie lorem, sed lobortis dui nulla malesuada purus. Quisque id viverra lorem. Aliquam rutrum mattis varius. Aenean lectus mi, imperdiet aliquam imperdiet ac, pretium sed neque. Duis molestie luctus tellus sit amet eleifend. Curabitur erat nisl, sagittis non magna eget, sagittis malesuada urna. Etiam nibh justo, egestas et ligula at, molestie auctor tortor. Aliquam hendrerit ante sit amet urna congue ultrices. Vivamus pellentesque risus sit amet est pretium tristique.</span></p>
                <a class="btn-show-more" href="#">Читать дальше...</a>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Объявления в городах</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Интересные <br>предложения</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


