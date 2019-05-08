<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use app\widgets\AdvertisementCat;
use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;

echo SearchAdverts::widget();
?>
<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <ul class="bread-crumbs">
                <li>
                    <a href="/"><?= Yii::t('app','Главная') ?></a>
                </li>
                <li>404</li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="not-found">
        <div class="holder-img">
            <img src="<?= Url::home(true)?>images/bg-46.png" alt="img">
        </div>
        <strong><?= Yii::t('app', 'Что-то пошло <br>не так...')?></strong>
        <p><?= Yii::t('app', 'К сожалению такой страницы не существует.')?> <a href="<?= Url::home(true) ?>"><?= Yii::t('app', 'Вернитесь на главную') ?>,</a> <?= Yii::t('app', 'либо попробуйте найти нужное вам объявление с помощью категорий.')?></p>
    </div>
</div>
<?= AdvertisementCat::widget() ?>
<?= FooterInfo::widget() ?>
