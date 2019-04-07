<?php
    $model->duration = $model->duration/24;

use app\components\TextExcerption;
use yii\helpers\Url; ?>
<ul class="vip-price">
    <li>
        <div class="icon">
            <i class="fas <?= $model->rate_icon ?>"></i>
        </div>
        <div class="text">
            <strong><?= $model->rate ?><span> (<?= $model->duration ?> <?= TextExcerption::getDayString($model->duration)?>)</span></strong>
            <p><?= $model->description ?></p>
        </div>
        <div class="holder-price">
            <span><?= $model->price ?><sup><?= Yii::t('app','грн')?></sup></span>
        </div>
        <?= $form ?>
    </li>
<!--    <li>-->
<!--        <div class="icon">-->
<!--            <i class="fas fa-crown"></i>-->
<!--        </div>-->
<!--        <div class="text">-->
<!--            <strong>Топ объявление <span>(7 дней)</span></strong>-->
<!--            <p>Ваше объявление отображается выше бесплатных и будет отмечено как VIP-объявление в течении недели</p>-->
<!--        </div>-->
<!--        <div class="holder-price">-->
<!--            <span>56<sup>грн</sup></span>-->
<!--        </div>-->
<!--    </li>-->
<!--    <li>-->
<!--        <div class="icon">-->
<!--            <i class="fas fa-angle-double-up"></i>-->
<!--        </div>-->
<!--        <div class="text">-->
<!--            <strong>Поднятие вверх списка <span>(1 день)</span></strong>-->
<!--            <p>Ваше объявление отображается в начале списка бесплатных объявлений в течении 1 дня</p>-->
<!--        </div>-->
<!--        <div class="holder-price">-->
<!--            <span>15<sup>грн</sup></span>-->
<!--        </div>-->
<!--    </li>-->
<!--    <li>-->
<!--        <div class="icon">-->
<!--            <i class="fas fa-angle-double-up"></i>-->
<!--        </div>-->
<!--        <div class="text">-->
<!--            <strong>Поднятие вверх списка <span>(7 дней)</span></strong>-->
<!--            <p>Ваше объявление отображается в начале списка бесплатных объявлений в течении недели</p>-->
<!--        </div>-->
<!--        <div class="holder-price">-->
<!--            <span>84<sup>грн</sup></span>-->
<!--        </div>-->
<!--    </li>-->
<!--    <li>-->
<!--        <div class="icon">-->
<!--            <i class="fas fa-briefcase"></i>-->
<!--        </div>-->
<!--        <div class="text">-->
<!--            <strong>Пакет поднятие + топ <span>(1 день)</span></strong>-->
<!--            <p>Ваше объявление отображается в начале списка и будет отмечено как VIP-объявление в течении 1 дня</p>-->
<!--        </div>-->
<!--        <div class="holder-price">-->
<!--            <span>22<sup>грн</sup></span>-->
<!--        </div>-->
<!--    </li>-->
<!--    <li>-->
<!--        <div class="icon">-->
<!--            <i class="fas fa-briefcase"></i>-->
<!--        </div>-->
<!--        <div class="text">-->
<!--            <strong>Пакет поднятие + топ <span>(7 дней)</span></strong>-->
<!--            <p>Ваше объявление отображается в начале списка и будет отмечено как VIP-объявление в течении недели</p>-->
<!--        </div>-->
<!--        <div class="holder-price">-->
<!--            <span>157<sup>грн</sup></span>-->
<!--        </div>-->
<!--    </li>-->
</ul>
<div class="no-advertising">
    <a class="old-ads" href="<?= Url::toRoute(['/myaccount/posts'])?>"><?= Yii::t('app', 'не рекламировать') ?></a>
    <div class="holder-text">
        <p><?= Yii::t('app', 'Вы можете воспользоваться услугами позже, перейдя  на страницу')?> <a href="<?= Url::toRoute(['/myaccount/posts'])?>"><?= Yii::t('app', 'Мои объявления') ?></a> <?= Yii::t('app', 'в личном кабинете.')?></p>
    </div>
</div>