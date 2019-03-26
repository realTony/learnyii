<?php

use app\components\TextExcerption;
use app\widgets\SearchAdverts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \app\modules\admin\models\Categories;
use app\models\Cities;
use app\widgets\UserBar;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

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
        <div class="title-text clone">
            <h1><?= Yii::t('app', 'Мои объявления')?></h1>
        </div>
        <div class="group-content">
            <?= UserBar::widget([
                'user' => $user
            ])?>
            <div class="content">
                <ul class="ad-status">
                    <li class="active">
                        <a href="#"><i class="fas fa-tags"></i> Активные объявления<sup><small>(3)</small></sup></a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-calendar-check"></i> На подтверждении<sup><small>(2)</small></sup></a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-eye-slash"></i> Архив<sup><small>(15)</small></sup></a>
                    </li>
                </ul>
                <?php if(! empty($models)): ?>
                <ul class="list-announcements active">
                    <?php foreach ($models as $item): ?>
                    <?php
                        $images = Url::home(true).'/'.$item->images[0]['image_name'];
                        $categories = Yii::createObject(Categories::className());
                        $categories->category = $item->category_id;
                        $cat  = $categories->category;
                    ?>
                        <li>
                            <!-- Fav items -->
                            <ul class="edit-list">
                                <li>
                                    <a href="<?= Url::toRoute('/myaccount/update/'.$item->id) ?>"><i class="fas fa-pen-square"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-shield-alt"></i></a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute('/myaccount/delete/'.$item->id) ?>"><i class="fas fa-trash-alt"></i></a>
                                </li>
                            </ul>
                            <!-- end fav -->
                            <a class="like-star" href="#">&#160;</a>
                            <a href="<?= Url::to('/advertisement/page/'.$item->id)?>">
                                <div class="holder-img">
                                    <?php if(! empty($item->images[0])):?>
                                        <img src="<?= $images ?>" alt="<?= $item->images[0]['alt'] ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="holder-text">
                                    <div class="group">
                                        <div class="topic">
                                            <span><i class="fas fa-shield-alt"></i> <?= $item->title ?></span>
                                            <p><?=$cat->title; ?></p>
                                        </div>


                                        <strong><?= $item->pricePerMonth ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                                    </div>
                                    <div class="overflow-text">
                                        <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                        <p><?= TextExcerption::excerptText($item->description, 110); ?></p>
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
            </div>
        </div>
    </div>
<?= \app\widgets\FooterInfo::widget(); ?>