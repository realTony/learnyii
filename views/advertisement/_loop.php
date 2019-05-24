<?php

use app\components\Premium;
use app\components\SiteComponents;
use app\components\TextExcerption;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<ul class="list-announcements">
<?php
foreach ($models as $model):?>
    <?php
        $likeClass = '';
        $likeClass = (SiteComponents::checkUserFav($model->id) == true ) ? 'active': '';
    ?>
    <li <?php if(Premium::checkPrem($model->id)): ?>class="premium" <?php endif ?>>
        <a class="like-star <?= $likeClass ?>" href="<?= Url::toRoute('/myaccount/default/make-fav')?>" data-id="<?= $model->id ?>">&#160;</a>
        <a href="<?= Url::to('/advertisement/page/'.$model->id)?>">
            <?php
                $img = (empty($model->images[0])) ? '/images/no-photo_item-small.png' : $model->images[0]['image_name'];
                $img = file_exists(realpath(Yii::getAlias('@webroot').$img)) ? $img : '/images/no-photo_item-small.png';
                ?>
            <div class="holder-img" style="background: url('<?= $img ?>') no-repeat center center; background-size: cover;" >
                <img src="/images/avatar-holder.png" alt="<?= (!empty($model->images[0])) ? $model->images[0]['alt'] : 'no-photo'?>">
            </div>
            <div class="holder-text">
                <div class="group">
                    <div class="topic">
                        <span><?= $model->title ?></span>
                    </div>
                    <strong><?= $model->pricePerMonth; ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                </div>
                <div class="overflow-text">
                    <div class="overflow-text">
                        <?php if(! empty($model->cityNames) && ! empty($model->districtNames)): ?>
                            <?php foreach ( $model->districtNames as $districtName): ?>
                                <span class="region"><em><?= $model->cityNames[0] ?></em>, <em><?= $districtName ?></em></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <p><?= TextExcerption::excerptText(Html::encode($model->description), 110); ?></p>
                    </div>
                </div>
            </div>
        </a>
    </li>
<?php endforeach; ?>
<?php if( $data->getCount() > 1):?>
    <?php
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