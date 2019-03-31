<?php

use app\widgets\FooterInfo;
use app\widgets\InfoPages;
use app\widgets\SearchAdverts;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = $breadcrumbs;
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
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                ?>
            </div>
        </div>
    </div>
<div class="container">
    <div class="group-content revers">
        <?= InfoPages::widget() ?>
        <div class="content">
            <div class="title-text">
                <h1><?= $model->title ?></h1>
            </div>
            <?= $model->options->content ?>

            <ul class="proposal-list how-it-work">
                <li>
                    <strong><?= Yii::t('app', 'зарегистрируйтесь') ?></strong>
                    <span><?= Yii::t('app', 'Это бесплатно!') ?></span>
                </li>
                <li>
                    <span class="bottom-strip"></span>
                    <div class="holder-block">
                        <div class="holder-img">
                            <img src="<?= Url::home(true) ?>images/bg-15.png" alt="img">
                        </div>
                        <div class="holder-text">
                            <strong><?= Yii::t('app', 'Создайте <br>Объявление')?></strong>
                        </div>
                    </div>
                </li>
                <li>
                    <span class="top-strip"></span>
                    <div class="holder-block">
                        <div class="holder-img">
                            <img src="<?= Url::home(true) ?>images/bg-16.png" alt="img">
                        </div>
                        <div class="holder-text">
                            <strong><?= Yii::t('app', 'Найдите <br>Клиента')?></strong>
                        </div>
                    </div>
                </li>
                <li>
                    <span class="bottom-strip"></span>
                    <div class="holder-block">
                        <div class="holder-img">
                            <img src="<?= Url::home(true) ?>images/bg-17.png" alt="img">
                        </div>
                        <div class="holder-text">
                            <strong><?= Yii::t('app', 'Выполните <br>договор')?></strong>
                        </div>
                    </div>
                </li>
                <li>
                    <span class="top-strip"></span>
                    <div class="holder-block">
                        <div class="holder-img">
                            <img src="<?= Url::home(true) ?>images/bg-18.png" alt="img">
                        </div>
                        <div class="holder-text">
                            <strong><?= Yii::t('app', 'Получите <br>оплату')?></strong>
                        </div>
                    </div>
                </li>
            </ul>
            <?= $model->options->after_content ?>
            <a href="<?= Url::to(['/account#register']) ?>" class="free-registration">
                <h2><?= Yii::t('app', 'зарегистрируйтесь' ) ?></h2>
                <span><?= Yii::t('app', 'Это бесплатно!')?></span>
            </a>
        </div>
    </div>
</div>
<?= FooterInfo::widget() ?>