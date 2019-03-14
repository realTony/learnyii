<?php

use app\widgets\SearchAdverts;
use yii\helpers\Url;
use app\modules\admin\models\Categories;

?>

<?php if(! empty($slider)): ?>
    <div class="promo-slider">
        <?php foreach ($slider as $slide):?>
            <div>
                <div class="img" style="background-image: url(<?= $slide ?>);"></div>
            </div>
        <?php endforeach;?>
    </div>
<?php endif; ?>

<?= SearchAdverts::widget() ?>

<!-- Advertisement main categories list -->
<div class="container">
    <?php if(! empty($adverts)): ?>
    <ul class="list-progress">
        <?php
            $i = 0;
            $last = count($adverts)-1;

            foreach ($adverts as $advert):
                $advert->category = $advert->id;
        ?>
        <li>
            <a href="<?= Url::home(true).$advert['link'] ?>">
                <div class="holder-img">
                    <?php if($i == 0): ?>
                    <i class="fas fa-car"></i>
                    <?php elseif ($i != $last): ?>
                    <i class="fas fa-bullhorn"></i>
                    <?php else: ?>
                    <i class="fas fa-pencil-ruler"></i>
                    <?php endif; ?>
                </div>
                <div class="holder-text">
                    <strong><?= $advert['title']?></strong>
                    <p><?= $advert->totalCount ?> <?= Yii::t('app', 'Объявлений')?></p>
                </div>
            </a>
        </li>
        <?php
            $i++;
            endforeach;
        ?>
    </ul>
    <?php endif; ?>
</div>

<!-- End of advertisement main categories list -->

<!-- New advertisement posts -->
<?php if(! empty($posts)): ?>
<div class="holder-section fon-grey relative">
    <div class="container">
        <div class="title-text">
            <h1><?= Yii::t('app', 'Новые объявления') ?></h1>
            <a class="old-ads" href="<?= Url::to(['/advertisement']) ?>"><?= Yii::t('app', 'Все объявления') ?></a>
        </div>
        <div class="slider-announcements">
            <ul class="list-announcements">
                <?php foreach ($posts as $item): ?>
                <?php
                    $categories = Yii::createObject(Categories::className());
                    $categories->category = $item->category_id;
                    $cat  = $categories->category;
                    ?>
                    <li>
                        <a class="like-star" href="#">&#160;</a>
                        <a href="<?= Url::to(['/advertisement/page/'.$item->id]) ?>">
                            <div class="holder-img">
                                <?php if(! empty($item->images[0]['image_name']) && $item->images[0]['image_name'] != '' ): ?>
                                <img src="<?= $item->images[0]['image_name'] ?>" alt="<?= $item->images[0]['alt']?>">
                                <?php endif; ?>
                            </div>
                            <div class="holder-text">
                                <span><?= $item->title ?></span>
                                <p><?= $cat['title'] ?></p>
                                <strong><?= $item->pricePerMonth ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- End of new advertisement posts -->

<?php if(! empty($promo) && $model->options->is_promo == 1): ?>
<div class="holder-section relative">
    <div class="container">
        <div class="title-text">
            <?php if(! empty($news)): ?>
                <h1><?= $news->title?></h1>
                <a class="old-ads" href="<?= Url::to(['news/category/']).$news->link ?>"><?= Yii::t('app','Все акции') ?></a>
            <?php endif; ?>
        </div>
        <div class="promotion">
            <?php
                $i = 0;
                $last = count($promo);

                foreach ($promo as $item):
            ?>
            <?php if($i == 0): ?>
            <div class="big-promotion">
                <a href="<?= Url::to(['news/'.$item->link]) ?>" class="holder-img">
                    <div class="date">
                        <strong><?= date( 'd', strtotime($item->created_at) ) ?></strong>
                        <strong><?= Yii::t('app', date('F', strtotime($item->created_at))) ?></strong>
                    </div>
                    <strong class="title"><?php $item->title ?></strong>
                    <?php if(! empty($item->post_image)):?>
                    <picture>
                        <source srcset="<?= $item->post_image ?>" media="(max-width: 850px)">
                        <source srcset="<?= $item->post_image ?>" media="(min-width: 851px)">
                        <img src="<?= $item->post_image ?>" alt="img">
                    </picture>
                    <?php endif; ?>
                </a>
            </div>
            <?php elseif($i == $last ): ?>
            <a href="<?= Url::to(['news/'.$item->link]) ?>" class="small-promotion">
                <div class="holder-img">
                    <div class="date">
                        <strong><?= date( 'd', strtotime($item->created_at) ) ?></strong>
                        <strong><?= Yii::t('app', date('F', strtotime($item->created_at))) ?></strong>
                    </div>
                    <strong class="title"><?= $item->title ?></strong>
                    <?php if(! empty($item->post_image)):?>
                    <img src="<?= $item->post_image ?>" alt="img">
                    <?php endif; ?>
                </div>
            </a>
            <?php else: ?>
                <div class="small-promotion">
                    <a href="<?= Url::to(['news/'.$item->link]) ?>" class="holder-img">
                        <div class="date">
                            <strong><?= date( 'd', strtotime($item->created_at) ) ?></strong>
                            <span><?= Yii::t('app', date('F', strtotime($item->created_at))) ?></span>
                        </div>
                        <strong class="title"><?= $item->title ?></strong>
                        <?php if(! empty($item->post_image)):?>
                            <img src="<?= $item->post_image ?>" alt="img">
                        <?php endif; ?>
                    </a>
                </div>
                <?php endif; ?>
            <?php
                    $i++;
                endforeach;
            ?>
        </div>

    </div>
</div>
<?php endif; ?>

<div class="accordion">
    <div class="holder-section fon-grey">
        <div class="container">
            <div class="item-accordion">
                <div class="title-text">
                    <h1 class="btn-accordion"><?= Yii::t('app', 'Как это работает?') ?></h1>
                </div>
                <div class="content-accordion">
                    <div class="holder-box-hidden">
                        <?= $model->options->how_it_works ?>
                        <a class="btn-show-more" href="<?= Url::to(['/how-it-works']) ?>"><?= Yii::t('app', 'Читать дальше...') ?></a>
                    </div>
                    <ul class="proposal-list">
                        <li>
                            <a href="<?= Url::to(['/account#register']) ?>">
                                <strong><?= Yii::t('app', 'зарегистрируйтесь') ?></strong>
                                <span><?= Yii::t('app', 'Это бесплатно!') ?></span>
                            </a>
                        </li>
                        <li>
                            <span class="bottom-strip"></span>
                            <div class="holder-block">
                                <div class="holder-img">
                                    <img src="<?= Url::home(true) ?>images/bg-15.png" alt="img">
                                </div>
                                <div class="holder-text">
                                    <strong><?= Yii::t('app', 'Создайте') ?> <br><?= Yii::t('app', 'Объявление') ?></strong>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="top-strip"></span>
                            <div class="holder-block">
                                <div class="holder-img">
                                    <img src="<?= Url::home(true) ?>images/bg-16.png" alt="img">
                                </div>
                                <div class="holder-text">
                                    <strong><?= Yii::t('app', 'Найдите') ?> <br><?= Yii::t('app', 'Клиента') ?></strong>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="bottom-strip"></span>
                            <div class="holder-block">
                                <div class="holder-img">
                                    <img src="<?= Url::home(true) ?>images/bg-17.png" alt="img">
                                </div>
                                <div class="holder-text">
                                    <strong><?= Yii::t('app', 'Выполните') ?> <br><?= Yii::t('app', 'договор') ?></strong>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="top-strip"></span>
                            <div class="holder-block">
                                <div class="holder-img">
                                    <img src="<?= Url::home(true) ?>images/bg-18.png" alt="img">
                                </div>
                                <div class="holder-text">
                                    <strong><?= Yii::t('app', 'Получите') ?> <br><?= Yii::t('app', 'оплату') ?></strong>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="holder-box-hidden white">
                        <?= $model->seo_text ?>
                        <a class="btn-show-more" href="#"><?= Yii::t('app', 'Читать дальше...') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="holder-section">
        <div class="container">
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