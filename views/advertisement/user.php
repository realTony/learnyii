<?php

use app\components\TextExcerption;
use app\widgets\AdvertisementFilter;
use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use app\widgets\SortingForm;
use app\widgets\UserBar;
use yii\helpers\Html;
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
            <?= AdvertisementFilter::widget([
                    'filter' => $sideFilter,
                    'options' => [
                        'user_id' => $user->id,
                        'use_wrapper' => false,
                        'show_filters' => true
                    ],
            ])?>
        </div>
        <div class="content">
            <h4><?= Yii::t('app', 'Все объявления пользователя') ?> </h4>
            <h1><?= $user->username; ?></h1>
            <div class="holder-information">
                <span class="filters"><?= Yii::t('app', 'информация')?></span>
                <div class="block-filter">
                    <?= SortingForm::widget([
                        'filter' => $filter,
                        'viewButton' => true
                    ]) ?>
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
                <?= $this->render('_loop', [
                    'models' => $models,
                    'data' => $data,
                    'pages' => $pages
                ]);
                ?>
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