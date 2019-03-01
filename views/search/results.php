<?php

use app\components\TextExcerption;
use app\widgets\SearchAdverts;
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
            <?= \app\widgets\SortingForm::widget([
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
                    $img = Url::home(true).'/'.$item->images[0]['image_name'];
                    $categories = Yii::createObject(Categories::className());
                    $categories->category = $item->category_id;
                    $cat  = $categories->category;
                ?>
                    <li <?php if($item->isPremium ): ?> class="premium" <?php endif; ?>>
                        <a class="like-star" href="#">&#160;</a>
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
                                    <p><?= TextExcerption::excerptText($item->description, 110); ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
                    <li>
                        <a href="#">
                            <div class="load-more">
                                <div>
                                    <i class="fas fa-sync-alt"></i>
                                    <span><?= Yii::t('app', 'Загрузить еще 30 объявлений')?></span>
                                </div>
                            </div>
                        </a>
                    </li>
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
<div class="accordion">
    <div class="holder-section">
        <div class="container">
            <div class="holder-box-hidden clone">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut nunc in eros posuere euismod in a tortor. Phasellus nunc orci, vehicula in <span class="box-hidden">hendrerit eu, hendrerit quis neque. Duis eget turpis nec enim vulputate tristique vel vel sem. Etiam sagittis facilisis nisl, id ultricies ante commodo vitae. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer nec elit sollicitudin, vehicula massa vel, accumsan dolor. Phasellus placerat quam justo, eu porttitor ante imperdiet a. Duis imperdiet, lacus at placerat bibendum, lacus arcu molestie lorem, sed lobortis dui nulla malesuada purus. Quisque id viverra lorem. Aliquam rutrum mattis varius. Aenean lectus mi, imperdiet aliquam imperdiet ac, pretium sed neque. Duis molestie luctus tellus sit amet eleifend. Curabitur erat nisl, sagittis non magna eget, sagittis malesuada urna. Etiam nibh justo, egestas et ligula at, molestie auctor tortor. Aliquam hendrerit ante sit amet urna congue ultrices. Vivamus pellentesque risus sit amet est pretium tristique.</span></p>
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