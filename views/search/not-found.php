<?php

use app\widgets\AdvertisementCat;
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
            <img src="<?= Url::home(true) ?>images/svg/search-negative.svg" alt="img">
        </div>
        <strong><?= Yii::t('app', 'по запросу')?> <span><?= $title ?></span> <br><?= Yii::t('app', 'ничего не найдено')?></strong>
        <p><?= Yii::t('app', 'К сожалению такой страницы не существует.') ?> <a href="<?= Url::home() ?>" ><?= Yii::t('app', 'Вернитесь на главную') ?>,</a> <?= Yii::t('app', 'либо попробуйте найти нужное вам объявление с помощью категорий.')?></p>
    </div>
</div>

<?= AdvertisementCat::widget() ?>
<?= FooterInfo::widget()?>