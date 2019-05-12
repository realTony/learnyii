<?php

use app\components\SiteComponents;
use app\components\TextExcerption;
use yii\helpers\Html;
use yii\helpers\Url;
use \app\modules\admin\models\Categories;

foreach ($model as $item ):
    $img =  (! empty($item->images[0]['image_name']))? Url::home(true).'/'.$item->images[0]['image_name'] : '';
    $categories = Yii::createObject(Categories::className());
    $categories->category = $item->category_id;
    $cat  = $categories->category;
    $likeClass = '';
    $likeClass = (SiteComponents::checkUserFav($model->id) == true) ? 'active' : '';

    ?>
    <li <?php if($item->isPremium ): ?> class="premium" <?php endif; ?>>
        <a class="like-star <?= $likeClass ?>" href="<?= Url::toRoute('/myaccount/default/make-fav')?>" data-id="<?= $item->id ?>">&#160;</a>
        <a href="<?= Url::to('/advertisement/page/'.$item->id)?>">
            <div class="holder-img">
                <?php if(! empty($item->images)): ?>
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