<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use app\widgets\AdvertisementCat;
use app\widgets\FooterInfo;
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
        <strong><?= Yii::t('app', 'Что-то пошло <br>не так...')?></strong>
        <p>К сожалению такой страницы не существует. <a href="<?= \yii\helpers\Url::home(true) ?>">Вернитесь на главную,</a> либо попробуйте найти нужное вам объявление с помощью категорий.</p>
    </div>
</div>
<?= AdvertisementCat::widget() ?>
<?= FooterInfo::widget() ?>
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
