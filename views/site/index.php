<?php

use app\components\Images;
use app\components\Premium;
use app\components\SiteComponents;
use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use app\modules\admin\models\Categories;

?>

<?php if(! empty($slider)): ?>
    <div class="promo-slider">
        <?php foreach ($slider as $slide):
            $slide = str_replace('//uploads', '/uploads', $slide);
            ?>
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
                    <strong><?= Yii::t('app', $advert['title']) ?></strong>
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
        <div class="main-slider-announcements">
            <ul class="list-announcements">
                <?php foreach ($premAdverts as $item): ?>
                    <?php
                    $categories = Yii::createObject(Categories::className());
                    $categories->category = $item->category_id;
                    $cat  = $categories->category;
                    $img = (empty($item->images[0])) ? '/images/no-photo_item-small.png' : $item->images[0]['image_name'];
                    $img = Images::isThumbnailExists($img);

                    ?>
                    <li <?php if(Premium::checkPrem($item->id)): ?>class="premium" <?php endif ?>>
                        <?php
                        $likeClass = '';
                        $likeClass = (SiteComponents::checkUserFav($item->id) == true ) ? 'active': '';
                        ?>
                        <a class="like-star <?= $likeClass ?>" href="<?= Url::toRoute('/myaccount/default/make-fav')?>" data-id="<?= $item->id ?>">&#160;</a>
                        <a href="<?= Url::to(['/advertisement/page/'.$item->id]) ?>">
                            <div class="holder-img" style="background: url('<?= $img ?>') no-repeat 50% 50%; background-size: cover;">
                                <img src="<?= '/images/announcement_holder.png' ?>" alt="<?= (!empty($item->images[0])) ? $item->images[0]['alt'] : 'no-photo'?>">
                            </div>
                            <div class="holder-text">
                                <span><?= $item->title ?></span>
                                <p><?= $cat['title'] ?></p>
                                <strong><?= $item->pricePerMonth ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></strong>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
                <?php foreach ($posts as $item): ?>
                <?php
                    $categories = Yii::createObject(Categories::className());
                    $categories->category = $item->category_id;
                    $cat  = $categories->category;
                    $img = (empty($item->images[0])) ? '/images/no-photo_item-small.png' : $item->images[0]['image_name'];
                    $img = Images::isThumbnailExists($img);

                    ?>
                    <li <?php if(Premium::checkPrem($item->id)): ?>class="premium" <?php endif ?>>
                        <?php
                            $likeClass = '';
                            $likeClass = (SiteComponents::checkUserFav($item->id) == true ) ? 'active': '';
                        ?>
                        <a class="like-star <?= $likeClass ?>" href="<?= Url::toRoute('/myaccount/default/make-fav')?>" data-id="<?= $item->id ?>">&#160;</a>
                        <a href="<?= Url::to(['/advertisement/page/'.$item->id]) ?>">
                            <div class="holder-img" style="background: url('<?= $img ?>') no-repeat 50% 50%; background-size: cover;">
                                <img src="<?= '/images/announcement_holder.png' ?>" alt="<?= (!empty($item->images[0])) ? $item->images[0]['alt'] : 'no-photo'?>">
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

<?php if(! empty($promo) && (! empty($model->options->is_promo) && $model->options->is_promo == 1)): ?>
<div class="holder-section relative">
    <div class="container">
        <div class="title-text">
            <?php if(! empty($news)): ?>
                <h1><?= $news->title?></h1>
                <a class="old-ads" href="<?= Url::to(['/news/category']).'/'.$news->link ?>"><?= Yii::t('app','Все акции') ?></a>
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
    <?php if(! empty($show_how_it_works) && $show_how_it_works == 1): ?>
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
                                <strong><?= Yii::t('app', 'Зарегистрируйтесь') ?></strong>
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
                                    <strong><?= Yii::t('app', 'Создайте <br> Объявление') ?> </strong>
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
                                    <strong><?= Yii::t('app', 'Найдите <br> клиента') ?></strong>
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
                                    <strong><?= Yii::t('app', 'Выполните <br> договор') ?></strong>
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
                                    <strong><?= Yii::t('app', 'Получите <br> оплату') ?></strong>
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
    <?php endif; ?>
    <?= FooterInfo::widget([
            'options' => [
                    'has_seo' => false
            ]
    ]) ?>
</div>
