<!-- Premium advertisements loop-->
<?php

use app\components\Premium;
use app\components\SiteComponents;
use app\components\TextExcerption;
use yii\helpers\Html;
use yii\helpers\Url;

if(! empty($premium)):
    foreach ($premium as $model):
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

    <?php endforeach;
endif;
