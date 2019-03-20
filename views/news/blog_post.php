<?php

use app\widgets\SearchAdverts;
use app\widgets\SimilarNews;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$options = $model->options;

$currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
$options['content'] = (empty($options['content']))? '' : $options['content'];
$options['content'] =  ($currentLang == 'uk' && !empty($model->translation['content']))? $model->translation['content']: $options['content'];
$this->params['breadcrumbs'] = $breadcrumbs;
?>
<?= SearchAdverts::widget() ?>
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
    <div class="group-content revers">
        <div class="aside-right">
        <?= SimilarNews::widget([
                'category' => $model->category_id,
                'currentId' => $model->id,
                'options' => [

                ]
        ]);?>
        </div>
        <div class="content">
            <div class="title-text">
                <h1><?= $model->title; ?></h1>
            </div>
            <div class="blog-photo">
                <?= Html::img('@web'.$model->post_image, ['alt' => $model->title] )?>
            </div>
            <?= Html::decode($options['content']) ?>

            <div class="share">
                <span class="share-title"><?=\Yii::t('app', 'Поделиться') ?></span>
                <?= \ymaker\social\share\widgets\SocialShare::widget([
                    'configurator'  => 'socialShare',
                    'url'           => Url::toRoute($model->link, true),
                    'title'         => $model->title,
                    'description'   => $model->description,
                    'imageUrl'      => Url::to('@web'.$model->post_image, true),
                    'containerOptions' => [
                            'tag' => 'ul',
                            'class' => 'social-list'
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?= \app\widgets\FooterInfo::widget() ?>