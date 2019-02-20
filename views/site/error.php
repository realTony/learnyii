<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use app\widgets\SearchAdverts;
use yii\helpers\Html;

$this->title = $name;

echo SearchAdverts::widget();
?>
<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <ul class="bread-crumbs">
                <li>
                    <a href="#">Главная</a>
                </li>
                <li>404</li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="not-found">
        <div class="holder-img">
            <img src="<?= \yii\helpers\Url::home(true)?>images/bg-46.png" alt="img">
        </div>
        <strong>Что-то пошло <br>не так...</strong>
        <p>К сожалению такой страницы не существует. <a href="<?= \yii\helpers\Url::home(true) ?>">Вернитесь на главную,</a> либо попробуйте найти нужное вам объявление с помощью категорий.</p>
    </div>
</div>
<div class="inform-nav">
    <div class="container">
        <div class="group">
            <div class="holder-block">
                <a  href="#" class="subsection-title">
                    <div class="holder-img">
                        <i class="fas fa-car"></i>
                    </div>
                    <span>Транспорт</span>
                </a>
                <ul>
                    <li>
                        <a href="#">Легковые автомобили</a>
                    </li>
                    <li>
                        <a href="#">Мото</a>
                    </li>
                    <li>
                        <a href="#">Велосипеды</a>
                    </li>
                    <li>
                        <a href="#">Грузовики</a>
                    </li>
                </ul>
            </div>
            <div class="holder-block">
                <a href="#" class="subsection-title">
                    <div class="holder-img">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <span>Реклама</span>
                </a>
                <ul>
                    <li>
                        <a href="#">Полная обклейка</a>
                    </li>
                    <li>
                        <a href="#">Частичная обклейка</a>
                    </li>
                    <li>
                        <a href="#">Навесная реклама</a>
                    </li>
                    <li>
                        <a href="#">Реклама в салоне</a>
                    </li>
                </ul>
            </div>
            <div class="holder-block">
                <a href="#" class="subsection-title">
                    <div class="holder-img">
                        <i class="fas fa-pencil-ruler"></i>
                    </div>
                    <span>Исполнители</span>
                </a>
                <ul>
                    <li>
                        <a href="#">Типографии</a>
                    </li>
                    <li>
                        <a href="#">Дизайнеры</a>
                    </li>
                    <li>
                        <a href="#">Поклейщики</a>
                    </li>
                </ul>
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
<!--<div class="site-error">-->
<!---->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    <div class="alert alert-danger">-->
<!--        --><?//= nl2br(Html::encode($message)) ?>
<!--    </div>-->
<!---->
<!--    <p>-->
<!--        The above error occurred while the Web server was processing your request.-->
<!--    </p>-->
<!--    <p>-->
<!--        Please contact us if you think this is a server error. Thank you.-->
<!--    </p>-->
<!---->
<!--</div>-->
