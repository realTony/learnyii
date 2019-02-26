<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use app\components\TextExcerption;

$this->params['breadcrumbs'] = $breadcrumbs;
?>

<?= \app\widgets\SearchAdverts::widget(); ?>

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
    <div class="group-content">
        <?= \app\widgets\AdvertisementFilter::widget() ?>

        <div class="content">
            <h1><?= Yii::t('app', 'Все объявления')?></h1>
            <div class="holder-filters">
                <span class="filters">фильтры</span>
                <div class="block-filter">

                </div>
            </div>
            <div class="form-content">
                <form>
                    <fieldset>
                        <div class="group">
                            <div class="holder-input">
                                <div class="city-input ui-widget">
                                    <input class="tags-city" type="text" placeholder="Город">
                                </div>
                                <div class="city-input ui-widget">
                                    <input class="district" type="text" placeholder="Район">
                                </div>
                            </div>
                            <div class="category-input">
                                <select name="dropdown" class="dropdown">
                                    <option>По возрастанию цены</option>
                                    <option>По убыванию цены</option>
                                    <option>По популярности</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div class="holder-view">
                    <a class="view-list" href="#">
                        <i class="fas fa-th-large"></i>
                        <i class="fas fa-list"></i>
                    </a>
                </div>
            </div>
            <ul class="list-announcements">
                <?php
                foreach ($models as $model) {
                    ?>
                    <li>
                        <a class="like-star" href="#">&#160;</a>
                        <a href="<?= Url::to('/advertisement/page/'.$model->id)?>">
                            <?php if(! empty($model->images)):
                                $img = Url::home(true).'/'.$model->images[0]['image_name'];
                                ?>
                                <div class="holder-img">
                                    <img src="<?= $img ?>" alt="img">
                                </div>
                            <?php else:?>
                                <div class="holder-img">
                                    <img src="<?= Url::home(true); ?>/images/img-2.jpg" alt="img">
                                </div>
                            <?php endif?>
                            <div class="holder-text">
                                <div class="group">
                                    <div class="topic">
                                        <span><?= $model->title ?></span>
                                    </div>
                                    <strong><?= $model->pricePerMonth; ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                                </div>
                                <div class="overflow-text">
                                    <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                    <p><?= TextExcerption::excerptText($model->description, 110); ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>


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
<?= \app\widgets\FooterInfo::widget() ?>