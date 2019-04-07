<?php

use app\components\TextExcerption;
use app\models\PremiumRates;
use app\widgets\PremiumFlash;
use app\widgets\SearchAdverts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \app\modules\admin\models\Categories;
use app\models\Cities;
use app\widgets\UserBar;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$categories = Yii::createObject(Categories::className());
$stickAreas = Yii::createObject(\app\models\StickingAreas::className());
$types = Yii::createObject(\app\models\AdvType::className());
$catList = $categories->advertisement;
$subList = $categories->subAdvertisement;
$areas  = $stickAreas->stickingAreas;
$types  =  $types->types;
$this->params['breadcrumbs'] = $breadcrumbs;

?>
<?= SearchAdverts::widget()?>
    <div class="holder-crumbs">
        <div class="container">
            <div class="holder-bread-crumbs">
                <?php
                echo Breadcrumbs::widget([
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
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <?php if (in_array($type, ['successPost', 'danger', 'warning', 'info'])): ?>
                <?= PremiumFlash::widget([
                    'options' => ['class' => 'advertise'],
                    'body' => $message
                ]) ?>
            <?php endif ?>
        <?php endforeach ?>
        <div class="title-text clone">
            <h1><?= Yii::t('app', 'Мои объявления')?></h1>
        </div>
        <div class="group-content">
            <?= UserBar::widget([
                'user' => $user
            ])?>
            <div class="content">
                <ul class="ad-status">
                    <li <?php if($type == 'active'): ?>class="active" <?php endif; ?>>
                        <a href="<?= Url::to(['/myaccount/posts?type=active']); ?>"><i class="fas fa-tags"></i><?= Yii::t('app', 'Активные объявления')?><sup><small>(<?= $user->countActive ?>)</small></sup></a>
                    </li>
                    <li <?php if($type == 'moderation'): ?>class="active" <?php endif; ?>>
                        <a href="<?= Url::to(['/myaccount/posts?type=moderation']); ?>"><i class="fas fa-calendar-check"></i><?= Yii::t('app', 'На подтверждении')?><sup><small>(<?= $user->countModerated ?>)</small></sup></a>
                    </li>
                    <li <?php if($type == 'archived'): ?>class="active" <?php endif; ?>>
                        <a href="<?= Url::to(['/myaccount/posts?type=archived']); ?>">
                            <i class="fas fa-eye-slash"></i><?= Yii::t('app', 'Архив') ?><sup><small>(<?= $user->countArchive ?>)</small></sup>
                        </a>
                    </li>
                </ul>
                <img class="hidden loader" src="<?= Url::base(true) ?>/images/loader.svg" />
                <?php Pjax::begin([
                    'id' => 'account-posts',
                    'enablePushState' => false,
                    'timeout' => 5000,
                ]) ?>
                <?php if(! empty($models)): ?>
                <ul class="list-announcements active clone">
                    <?php foreach ($models as $item): ?>
                    <?php
                        $images = (! empty($item->images)) ? Url::home(true).'/'.$item->images[0]['image_name'] : '';
                        $categories = Yii::createObject(Categories::className());
                        $categories->category = $item->category_id;
                        $cat  = $categories->category;
                        $rates = (Yii::createObject(PremiumRates::className()))
                        ->rates;

                    ?>
                        <li>
                            <!-- Fav items -->
                            <ul class="edit-list">
                                <li>
                                    <a href="<?= Url::toRoute('/myaccount/update/'.$item->id) ?>"><i class="fas fa-pen-square"></i></a>
                                </li>
<!--                                <li>-->
<!--                                    <a href="#"><i class="fas fa-shield-alt"></i></a>-->
<!--                                </li>-->
                                <li>
                                    <a href="<?= Url::toRoute('/myaccount/delete/'.$item->id) ?>"><i class="fas fa-trash-alt"></i></a>
                                </li>
                                <li>
                                    <a class="btn-rates" href="#"><i class="fas fa-crown"></i></a>
                                    <ul class="holder-rates">
                                        <?php
                                            foreach ($rates as $id => $rate):
                                                $premItem = Yii::createObject(PremiumRates::className())
                                            ->findOne(['id' => $id]);
                                                $premItem->duration = $premItem->duration/24;
                                        ?>
                                            <li>
                                                <a href="<?= Url::toRoute(['/myaccount/premium/'.$item->id.'/'.$id])?>">
                                                    <dl>
                                                        <dt><i class="fas fa-check"></i> <?= Yii::t('app', $rate)?> <span>(<?=  $premItem->duration ?> <?= TextExcerption::getDayString($premItem->duration) ?>)</span></dt>
                                                        <dd><?= $premItem->price ?><sup> <?= Yii::t('app', 'грн')?></sup></dd>
                                                    </dl>
                                                </a>
                                            </li>
                                        <?php
                                            endforeach;
                                        ?>

<!--                                        <li>-->
<!--                                            <a href="#">-->
<!--                                                <dl>-->
<!--                                                    <dt><i class="fas fa-check"></i>Топ объявление <span>(7 день)</span></dt>-->
<!--                                                    <dd>10<sup>грн</sup></dd>-->
<!--                                                </dl>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a href="#">-->
<!--                                                <dl>-->
<!--                                                    <dt><i class="fas fa-check"></i>Поднятие вверх списка  <span>(1 день)</span></dt>-->
<!--                                                    <dd>10<sup>грн</sup></dd>-->
<!--                                                </dl>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a href="#">-->
<!--                                                <dl>-->
<!--                                                    <dt><i class="fas fa-check"></i>Поднятие вверх списка  <span>(7 день)</span></dt>-->
<!--                                                    <dd>10<sup>грн</sup></dd>-->
<!--                                                </dl>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a href="#">-->
<!--                                                <dl>-->
<!--                                                    <dt><i class="fas fa-check"></i>Пакет поднятие + топ <span>(1 день)</span></dt>-->
<!--                                                    <dd>10<sup>грн</sup></dd>-->
<!--                                                </dl>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a href="#">-->
<!--                                                <dl>-->
<!--                                                    <dt><i class="fas fa-check"></i>Пакет поднятие + топ <span>(7 день)</span></dt>-->
<!--                                                    <dd>10<sup>грн</sup></dd>-->
<!--                                                </dl>-->
<!--                                            </a>-->
<!--                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                            <!-- end fav -->
                            <a class="like-star" href="#">&#160;</a>
                            <a href="<?= Url::to('/advertisement/page/'.$item->id)?>">
                                <div class="holder-img" <?php if(! empty($item->images[0])):?> style="background: url('<?= $images ?>') no-repeat center center; background-size: cover;" <?php endif; ?>>
                                    <?php if(! empty($item->images[0])):?>
                                        <img src="/images/avatar-holder.png" alt="<?= $item->images[0]['alt'] ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="holder-text">
                                    <div class="group">
                                        <div class="topic">
                                            <span>
<!--                                                <i class="fas fa-shield-alt"></i> -->
                                                <?= $item->title ?></span>
                                            <p><?=$cat->title; ?></p>
                                        </div>


                                        <strong><?= $item->pricePerMonth ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                                    </div>
                                    <div class="overflow-text">
                                        <?php if(! empty($item->cityNames) && ! empty($item->districtNames)):
                                            ?>
                                            <?php foreach ( $item->districtNames as $districtName): ?>
                                            <span class="region"><em><?= $item->cityNames[0] ?></em>, <em><?= $districtName ?></em></span>
                                        <?php endforeach;
                                        endif; ?>
                                        <p><?= Html::encode(TextExcerption::excerptText($item->description, 110)) ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
                <?php endif; ?>

                <?php if (! empty($pages) && $pages->pageSize < $pages->totalCount):?>
                    <div class="holder-pagination">
                        <a class="prev-page" href="#">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <?php
                        if(! empty( $pages) ) {
                            echo LinkPager::widget([
                                'pagination' => $pages,
                            ]);
                        }
                        ?>
                        <a class="next-page" href="#">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
<?= \app\widgets\FooterInfo::widget(); ?>