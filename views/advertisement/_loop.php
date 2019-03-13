<?php

use app\components\TextExcerption;
use yii\helpers\Url;

foreach ($models as $model) {
    ?>
    <li>
        <a class="like-star" href="#" data-id="<?= $model->id ?>">&#160;</a>
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
                    <?php if(! empty($model->cityNames) && ! empty($model->districtNames)): ?>
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
?>
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