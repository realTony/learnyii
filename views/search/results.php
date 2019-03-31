<?php

use app\components\TextExcerption;
use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use app\widgets\SortingForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use \app\modules\admin\models\Categories;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>

<?= SearchAdverts::widget() ?>
<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <?= Breadcrumbs::widget([
                'options' => [
                    'class' => 'bread-crumbs'
                ],
                'itemTemplate' => "<li>{link}</li>\n", // template for all links
                'links' => $breadcrumbs,
            ]);
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="group-content">
        <div class="content">
            <div class="title-text">
                <h1><?= Yii::t('app', 'Результаты поиска') ?> <span><?= $title['textRequest'] ?></span></h1>
            </div>
            <div class="holder-filters">
                <span class="filters"><?= Yii::t('app', 'Фильтры')?></span>
                <div class="block-filter">

                </div>
            </div>
            <?= SortingForm::widget([
                    'filter' => $filter
            ])?>
            <?php Pjax::begin([
                'id' => 'search-sort',
                'enablePushState' => false,
                'timeout' => false,
                'formSelector' => '#sortingForm'
            ]) ?>
            <?php if(!empty($model)):?>
                <ul class="list-announcements active">
                <?php foreach ($model as $item ):
                    $img = (! empty($item->images) )? Url::home(true).'/'.$item->images[0]['image_name']: '';
                    $categories = Yii::createObject(Categories::className());
                    $categories->category = $item->category_id;
                    $cat  = $categories->category;
                ?>
                    <li <?php if($item->isPremium ): ?> class="premium" <?php endif; ?>>
                        <a class="like-star" href="#">&#160;</a>
                        <a href="<?= Url::to('/advertisement/page/'.$item->id)?>">
                            <div class="holder-img">
                                <?php if(! empty($item->images) && ! empty($item->images[0])): ?>
                                    <img src="<?= $img ?>" alt="<?= $item->images[0]['alt']?>">
                                <?php endif?>
                            </div>
                            <div class="holder-text">
                                <div class="group">
                                    <div class="topic">
                                        <span><?= $item->title ?></span>
                                        <p><?= $cat->title; ?></p>
                                    </div>
                                    <strong><?= $item->pricePerMonth; ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                                </div>
                                <div class="overflow-text">
                                    <?php
                                    if(! empty($item->cityNames) && ! empty($item->districtNames)):
                                        ?>
                                        <?php foreach ( $item->districtNames as $districtName): ?>
                                        <span class="region"><em><?= $item->cityNames[0] ?></em>, <em><?= $districtName ?></em></span>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    <p><?= TextExcerption::excerptText(Html::encode($item->description), 110); ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
                    <?php if( $data->getCount() > 1):

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

                        if( $itemsLeft > 0): ?>
                            <li class="ajax-load">
                                <a class="ajax-load" href="#">
                                    <div class="load-more">
                                        <div>
                                            <i class="fas fa-sync-alt"></i>
                                            <span><?= Yii::t('app', 'Загрузить еще '). ($itemsLeft). $txt ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
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