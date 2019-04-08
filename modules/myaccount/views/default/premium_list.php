<?php

use app\components\TextExcerption;
use app\widgets\UserBar;
use yii\helpers\Url;

?>
<?= \app\widgets\SearchAdverts::widget()?>
<div class="holder-crumbs">
    <div class="container">
        <?= \yii\widgets\Breadcrumbs::widget([
            'links' => $breadcrumbs,
            'options'=> [
                'class' => 'bread-crumbs'
            ]
        ]) ?>
    </div>
</div>

<div class="container">
    <div class="title-text clone">
        <h1><?= $this->title ?></h1>
    </div>
    <div class="group-content">
        <?= UserBar::widget([
            'user' => $user
        ])?>
        <div class="content">
            <?= $this->render('pricelist', [
                'model' => $model,
                'advertisementId' => $advertisementId
            ])?>
            <div class="no-advertising">
                <a class="old-ads" href="<?= Url::toRoute(['/myaccount/posts'])?>"><?= Yii::t('app', 'не рекламировать') ?></a>
                <div class="holder-text">
                    <p><?= Yii::t('app', 'Вы можете воспользоваться услугами позже, перейдя  на страницу')?> <a href="<?= Url::toRoute(['/myaccount/posts'])?>"><?= Yii::t('app', 'Мои объявления') ?></a> <?= Yii::t('app', 'в личном кабинете.')?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<br>