<?php

use app\components\TextExcerption;

?>
<ul class="vip-price">
    <?php
    if( count($model) > 1) {

        foreach ($model as $item ):?>
            <?php
            $form = $item
                ->setAdvertisement($advertisementId)
                ->getLiqForm();
            $item->duration = $item->duration/24;
            ?>
            <li>
                <div class="icon">
                    <i class="fas <?= $item->rate_icon ?>"></i>
                </div>
                <div class="text">
                    <strong><?= $item->rate ?><span> (<?= $item->duration ?> <?= TextExcerption::getDayString($item->duration)?>)</span></strong>
                    <p><?= $item->description ?></p>
                    <?= $form ?>
                </div>
                <div class="holder-price">
                    <span><?= $item->price ?><sup><?= Yii::t('app','грн')?></sup></span>
                </div>
            </li>
        <?php endforeach;
    } else {
            $form = $model[0]
                ->setAdvertisement($advertisementId)
                ->getLiqForm();
                $model[0]->duration = $model[0]->duration/24;
            ?>
            <li>
                <div class="icon">
                    <i class="fas <?= $model[0]->rate_icon ?>"></i>
                </div>
                <div class="text">
                    <strong><?= $model[0]->rate ?><span> (<?= $model[0]->duration ?> <?= TextExcerption::getDayString($model[0]->duration)?>)</span></strong>
                    <p><?= $model[0]->description ?></p>
                    <?= $form ?>
                </div>
                <div class="holder-price">
                    <span><?= $model[0]->price ?><sup><?= Yii::t('app','грн')?></sup></span>
                </div>
            </li>
        <?php
    }
?>
</ul>