<?php

use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

?>
<?= SearchAdverts::widget() ?>
<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <?= Breadcrumbs::widget([
                'options' => [
                    'class' => 'bread-crumbs'
                ],
                'itemTemplate' => "<li>{link}</li>\n", // template for all links
                'links' => $breadcrumbs,
            ]); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="search-negative">
        <div class="holder-img">
            <img src="<?= Url::home(true) ?>images/bg-50.png" alt="img">
        </div>
        <strong>по запросу <span><?= $title ?></span> <br>ничего не найдено</strong>
        <p><?= Yii::t('app', 'К сожалению такой страницы не существует.') ?> <a href="<?= Url::home() ?>" ><?= Yii::t('app', 'Вернитесь на главную') ?>,</a> <?= Yii::t('app', 'либо попробуйте найти нужное вам объявление с помощью категорий.')?></p>
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
<?= FooterInfo::widget()?>