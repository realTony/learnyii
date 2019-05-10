<?php

use app\components\Premium;
use app\widgets\AdvertisementFilter;
use app\widgets\SearchAdverts;
use app\widgets\SortingForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use app\components\TextExcerption;
use yii\widgets\Pjax;

$this->params['breadcrumbs'] = $breadcrumbs;
?>

<?= SearchAdverts::widget(); ?>

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
    <div class="group-content">
        <?= AdvertisementFilter::widget([
            'filter' => $sideFilter,
            'options' => [
                    'user_id' => false,
                    'use_wrapper' => true,
                    'show_filters' => false,
                    'custom_filters' => false
            ]
        ]) ?>

        <div class="content">
            <h1><?= Yii::t('app', 'Все объявления')?></h1>
            <div class="holder-filters">
                <span class="filters"><?= Yii::t('app', 'Фильтры')?></span>
                <div class="block-filter">
                    <?= SortingForm::widget([
                        'filter' => $filter,
                        'viewButton' => true
                    ]) ?>
                </div>
            </div>
            <?= SortingForm::widget([
                'filter' => $filter,
                'viewButton' => true
            ])?>
            <?php Pjax::begin([
                'id' => 'search-sort',
                'enablePushState' => false,
                'timeout' => false,
                'formSelector' => '#sortingForm'
            ]) ?>
            <?= $this->render('_loop', [
                'models' => $models,
                'data' => $data,
                'pages' => $pages
            ]);
            ?>


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