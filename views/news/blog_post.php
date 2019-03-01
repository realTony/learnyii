<?php

use app\widgets\SearchAdverts;
use app\widgets\SimilarNews;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$options = json_decode($model->options);
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
<!--            <ul class="bread-crumbs">-->
<!--                <li>-->
<!--                    <a href="#">Главная</a>-->
<!--                </li>-->
<!--                <li>Новости</li>-->
<!--            </ul>-->
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
            <?= Html::decode($options->content) ?>

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
<div class="accordion">
    <div class="holder-section">
        <div class="container">
            <div class="holder-box-hidden clone">
                <?= Html::decode($model->seo_text) ?>
                <a class="btn-show-more" href="#">Читать дальше...</a>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Объявления в городах</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Интересные <br>предложения</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>