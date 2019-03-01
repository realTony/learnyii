<?php

use app\components\TextExcerption;
use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use app\widgets\SortingForm;
use app\widgets\UserBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use \app\modules\admin\models\Categories;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->params['breadcrumbs'] = $breadcrumbs;
?>
<?= SearchAdverts::widget() ?>

<div class="holder-crumbs">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => $breadcrumbs,
            'options'=> [
                'class' => 'bread-crumbs'
            ]
        ]) ?>
    </div>
</div>

<div class="container">
    <div class="group-content">
        <div class="aside-left">
            <?= UserBar::widget([
                'user' => $user,
                'options' => [
                        'has_wrapper' => false,
                        'profileClass' => 'aside-profile',
                        'enableMenu' => false,
                ]
            ])?>
            <form class="holder-aside-left">
                <fieldset>
                    <div class="aside-accordion">
                        <span class="title">Транспорт</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Легковые автомобили <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Мото <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Реклама</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Полная обклейка <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Исполнители</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Дизайнеры <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Цена (грн/мес)</span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/11000/1600/10000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Область поклейки</span>
                        <div class="expanded">
                            <ul class="list-checkbox">
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Полная обклейка</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n" checked>
                                        <span><i class="fas fa-check"></i> Частичная обклейка</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Навесная реклама</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Реклама в салоне</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">пробег (км/мес)</span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/2000/300/1000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="submit" type="submit" value="применить">
                </fieldset>
            </form>
        </div>
        <div class="content">
            <h4><?= Yii::t('app', 'Все объявления пользователя') ?> </h4>
            <h1><?= $user->username; ?></h1>
            <div class="holder-information">
                <span class="filters">информация</span>
                <div class="block-filter">

                </div>
            </div>
            <div class="holder-filters">
                <span class="filters"><?= Yii::t('app', 'Фильтры')?></span>
                <div class="block-filter">

                </div>
            </div>
            <?= SortingForm::widget([
                'filter' => $filter,
                'viewButton' => true
            ]) ?>
            <?php Pjax::begin([
                'id' => 'search-sort',
                'enablePushState' => false,
                'timeout' => false,
                'formSelector' => '#sortingForm'
            ]) ?>
            <?php if(! empty($models)): ?>
                <ul class="list-announcements">
                    <?php foreach ($models as $item): ?>
                        <?php
                        $images = Url::home(true).'/'.$item->images[0]['image_name'];
                        $categories = Yii::createObject(Categories::className());
                        $categories->category = $item->category_id;
                        $cat  = $categories->category;
                        ?>

                        <li <?php if($item->isPremium):?>class="premium" <?php endif ?>>
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
                                            <span><?= $item->title ?></span>
                                            <p><?= $cat->title ?></p>
                                        </div>
                                        <strong><?= $item->pricePerMonth ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                                    </div>
                                    <div class="overflow-text">
                                        <?php
                                        if(! empty($item->cityNames) && ! empty($item->districtNames)):
                                            ?>
                                            <?php foreach ( $item->districtNames as $districtName): ?>
                                            <span class="region"><em><?= $item->cityNames[0] ?></em>, <em><?= $districtName ?></em></span>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        <p><?= TextExcerption::excerptText($item->description, 110); ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach;?>
                    <li>
                        <a href="#">
                            <div class="load-more">
                                <div>
                                    <i class="fas fa-sync-alt"></i>
                                    <span><?= Yii::t('app', 'Загрузить еще 30 объявлений')?></span>
                                </div>
                            </div>
                        </a>
                    </li>
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

<?= FooterInfo::widget() ?>