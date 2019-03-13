<?php

use app\widgets\SortingForm;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use app\components\TextExcerption;
use \app\modules\admin\models\Categories;
use yii\widgets\Pjax;

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
        <?= \app\widgets\AdvertisementFilter::widget([
                'filter' => $sideFilter,
                'options' => [
                        'show_filters' => true,
                        'sub_only' => true,
                        'cat_id' => (!empty($catInfo->parent_id))? $catInfo->parent_id : $catInfo->id,
                        'user_id' => false,
                        'use_wrapper' => true
                ]
        ]); ?>

        <div class="content">
            <h1><?= $catInfo->title; ?></h1>
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
            <ul class="list-announcements">
                <?php
                foreach ($models as $model) {
                    $img = (! empty($model->images[0])) ? Url::home(true).'/'.$model->images[0]['image_name']: '';
                    $categories = Yii::createObject(Categories::className());
                    $categories->category = $model->category_id;
                    $cat  = $categories->category;

                    ?>
                    <li <?php if($model->isPremium):?>class="premium" <?php endif ?>>
                                <a class="like-star" href="#" data-id="<?= $model->id ?>">&#160;</a>
                                <a href="<?= Url::to('/advertisement/page/'.$model->id)?>">
                                    <div class="holder-img">
                                        <?php if(! empty($model->images)): ?>
                                            <img src="<?= $img ?>" alt="<?= $model->images[0]['alt']?>">
                                        <?php endif?>
                                    </div>
                                    <div class="holder-text">
                                        <div class="group">
                                            <div class="topic">
                                                <span><?= $model->title ?></span>
                                                <p><?= $cat->title; ?></p>
                                            </div>
                                            <strong><?= $model->pricePerMonth; ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                                        </div>
                                        <div class="overflow-text">
                                            <?php
                                            if(! empty($model->cityNames) && ! empty($model->districtNames)):
                                                ?>
                                                    <?php foreach ( $model->districtNames as $districtName): ?>
                                                        <span class="region"><em><?= $model->cityNames[0] ?></em>, <em><?= $districtName ?></em></span>
                                                    <?php endforeach; ?>
                                            <?php endif; ?>
                                            <p><?= TextExcerption::excerptText($model->description, 110); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                    <?php
                }

                $counter = $data->getTotalCount();
                $curr = ((int) $pages->page)+2;
                $maxLimit = $curr * (int) $pages->pageSize;
                $itemsLeft = ($maxLimit < $data->getTotalCount()) ? $pages->pageSize : ($data->getTotalCount() - $maxLimit) + $pages->pageSize;
                $txt = Yii::t('app', ' объявлений');

                switch ($itemsLeft) {
                    case 1:
                        $txt = Yii::t('app', ' объявление');
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $txt = Yii::t('app', ' объявления');
                        break;
                }
                ?>
                <?php if( $itemsLeft > 0): ?>
                    <li class="ajax-load">
                        <a href="#">
                            <div class="load-more">
                                <div>
                                    <i class="fas fa-sync-alt"></i>
                                    <span><?= Yii::t('app', 'Загрузить еще '). ($itemsLeft). $txt ?></span>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endif; ?>
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
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
<?= \app\widgets\FooterInfo::widget() ?>