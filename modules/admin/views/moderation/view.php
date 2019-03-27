<?php

use yii\helpers\Html; ?>
<div class="row">
    <div class="col-md-12">

        <div class="card bg-white m-b-lg">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                            <div class="grid-images">
                                <?php $i = 0; ?>
                                <?php foreach ($model->images as $image): ?>
                                    <?php if(strpos($image->image_name, 'thumbnails' )): ?>
                                        <div class="item ">
                                            <img class="d-block w-100" src="<?= $image->image_name ?>" alt="<?= $image->alt ?>">
                                        </div>
                                        <?php $i ++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                    </div>
                    <div class="col-md-4">
                            <p>
                                <strong><?= Yii::t('app', 'Заголовок:') ?></strong> <?= $model->title ?>
                            </p>
                            <p>
                                <strong><?= Yii::t('app', 'Категория:') ?></strong> <?= $model->category->title ?>
                            </p>
                            <p>
                                <strong><?= Yii::t('app', 'Подкатегория:') ?></strong> <?= $model->subCategory->title ?>
                            </p>
                            <p>
                                <strong><?= Yii::t('app', 'Область поклейки:') ?></strong> <?= $model->areaName ?>
                            </p>
                            <p>
                                <strong><?= Yii::t('app', 'Срок договора (мес):') ?></strong> <?= $model->contract_term ?>
                            </p>
                            <p>
                                <strong><?= Yii::t('app', 'Цена (грн/мес):') ?></strong> <?= $model->pricePerMonth ?> грн
                            </p>
                            <p><strong><?= Yii::t('app', 'Описание:') ?></p></strong>
                            <p><?= $model->description ?> </p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p>
                            <?= Html::a(Yii::t('app', 'Подтвердить'), ['approve', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                            <?= Html::a(Yii::t('app', 'Блокировать'), ['ban', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Вы действительно хотите заблокировать объявление?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>
                    </div></div>
            </div>
        </div>
    </div>
</div>