<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\widgets\SearchAdverts;
use app\widgets\UserBar;
use app\widgets\FooterInfo;

$this->params['breadcrumbs'][] = $this->title;
?>
<?= SearchAdverts::widget(); ?>
<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => $breadcrumbs,
                'options'=> [
                    'class' => 'bread-crumbs'
                ]
            ]) ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="title-text clone">
        <h1><?= Yii::t('app', 'Личный кабинет') ?></h1>
    </div>
    <div class="group-content">
        <?= UserBar::widget([
            'user' => $user
        ])?>
        <div class="content">
<!--            <div class="user-message">-->
<!--                <a href="#"><i class="fas fa-comments"></i> Сообщения<span>22</span></a>-->
<!--            </div>-->
            <div class="user-message">
                <a href="<?= Url::to(['/myaccount/posts?type=active']) ?>"><i class="fas fa-tags"></i> <?= Yii::t('app', 'Активные объявления') ?><span><?= $user->countActive ?></span></a>
            </div>
            <div class="holder-user-message">
                <div class="user-message">
                    <a href="<?= Url::to(['/myaccount/posts?type=moderation']) ?>"><i class="fas fa-calendar-check"></i> <?= Yii::t('app', 'Объявления на подтверждении') ?><span><?= $user->countModerated ?></span></a>
                </div>
                <div class="user-message">
                    <a href="<?= Url::to(['/myaccount/posts?type=archived']) ?>"><i class="fas fa-eye-slash"></i> <?= Yii::t('app', 'Архив') ?><span><?= $user->countArchive ?></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= FooterInfo::widget() ?>