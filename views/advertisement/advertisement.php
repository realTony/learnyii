<?php

use app\components\Images;
use app\components\Premium;
use app\models\Profile;
use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use \app\modules\admin\models\Categories;
use app\widgets\UserBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use ymaker\social\share\widgets\SocialShare;

?>
<?= SearchAdverts::widget();?>
<div class="holder-crumbs">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => $breadcrumbs,
            'options'=> [
                'class' => 'bread-crumbs'
            ]
        ]) ?>
    </div>
</div>
<div class="container">
    <div class="group-content revers">

        <div class="aside-right padding">
            <div class="aside-profile">
                <span class="price-month"><?= $model->pricePerMonth ?> <sup><small><?= Yii::t('app', 'грн/мес')?></small></sup></span>
                <div class="seller">
                    <div class="holder-img" style="background: url('<?= Profile::getUserAvatar( $user->id) ?>') no-repeat center center; background-size: cover;">
                        <img src="<?= Url::home(true).'images/avatar-holder.png'?>" alt="<?= $user->username ?>">
                    </div>
                    <div class="holder-text">
                        <a href="<?= Url::to('/advertisement/user/'.$model->authorId)?>" class="name"><?= $user->username ?></a>
                        <span><?= Yii::t('app', 'Дата регистрации')?></span>
                        <span class="date"><?= date('d.m.Y',$user->created_at) ?></span>
                    </div>
                </div>

                <div class="accordion-inform">
                    <div class="item">
                        <?php if(Yii::$app->user->isGuest) : ?>
                            <div class="holder-block">
                                <strong class="heading"><?= Yii::t('app', 'Контактная информация') ?></strong>
                                <div class="expanded">
                                    <span class="title"><?= Yii::t('app', 'Контактная информация') ?></span>
                                    <a  href="<?= Url::toRoute(['/account#login']) ?>"><?= Yii::t('app', 'Для просмотра необходимо войти в учётную запись') ?> </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="holder-block">
                            <strong class="heading"><?= Yii::t('app', 'Контактная информация') ?></strong>
                            <div class="expanded">
                                <span class="title"><?= Yii::t('app', 'Контактная информация') ?></span>
                                <ul class="list-contakt">
                                    <?php if(! empty($profile->phone)):?>
                                        <li>
                                            <i class="fas fa-phone"></i> <a href="tel:<?= $profile->phone ?>"><?= $profile->phone ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(! empty($profile->viber)):?>
                                        <li>
                                            <i class="fab fa-viber"></i> <a href="viber://chat?number=<?= $profile->viber ?>"><?= $profile->viber ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(! empty($profile->telegram)):?>
                                    <li>
                                        <i class="fab fa-telegram-plane"></i> <a href="tg://<?= $profile->telegram ?>"><?= $profile->telegram ?></a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(! empty($profile->whatsapp)):?>
                                    <li>
                                        <i class="fab fa-whatsapp"></i> <a href="https://wa.me/<?= $profile->whatsapp ?>"><?= $profile->whatsapp ?></a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(! empty($model->showEmail) && $model->showEmail):?>
                                    <li>
                                        <i class="far fa-envelope"></i> <a href='mailto:<?= $user->email ?>'><?= $user->email ?></a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    if(! empty($model->cityNames) && ! empty($model->districtNames)):
                    ?>
                    <div class="item">
                        <div class="holder-block">
                            <strong class="heading"><?= Yii::t('app', 'Районы города') ?></strong>
                            <div class="expanded">
                                <span class="title"><?= Yii::t('app', 'Районы города') ?></span>
                                <ul class="address-list">
                                    <?php foreach ( $model->districtNames as $districtName): ?>
                                        <li><i class="fas fa-map-marker-alt"></i> <?= $districtName ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="title-text">
                <h1><?= $model->title ?></h1>
            </div>
            <!-- Slider-->

            <?php if(! empty($model->images)): ?>
            <div class="car-slider">
                <?php foreach ($model->images as $image) :?>
                    <?php if( !strpos($image['image_name'],'thumbnail')):?>
                        <?php $img = file_exists(realpath(Yii::getAlias('@webroot').$image['image_name'])) ? $image['image_name'] : '/images/no-photo_big.png'; ?>
                        <?php $img = \app\components\Images::isImageExists($img); ?>
                        <div>
                            <div class="holder-img" style="background: url('<?= $img ?>') no-repeat center center; background-size: cover;">
                                <a class="like-star" href="<?= Url::toRoute('/myaccount/default/make-fav')?>" data-id="<?= $model->id ?>"tabindex="0">&nbsp;</a>
                                <img src="/images/post_placeholder.png" alt="<?= $image['alt'] ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach;?>
            </div>
            <?php else: ?>
                <div class="car-slider">
                    <?php $img = '/images/no-photo_big.png'; ?>
                    <?php $img = \app\components\Images::isImageExists($img); ?>
                    <div>
                        <div class="holder-img" style="background: url('<?= $img ?>') no-repeat center center; background-size: cover;">
                            <a class="like-star" href="<?= Url::toRoute('/myaccount/default/make-fav')?>" tabindex="0">&nbsp;</a>
                            <img src="/images/post_placeholder.png" alt="no photo">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="info-car">
                <ul class="list status-car">
                    <li>
                        <span><?= Yii::t('app', 'Состояние')?></span>
                        <strong>Новое</strong>
                    </li>
                    <?php if(! empty($model->areaName) && $model->areaName != ''): ?>
                    <li>
                        <span><?= Yii::t('app', 'Область рекламы')?></span>
                        <strong><?= $model->areaName ?></strong>
                    </li>
                    <?php endif; ?>
                    <li>
                        <span><?= Yii::t('app', 'Пробег') ?></span>
                        <strong><?= $model->distancePerMonth ?> <?= Yii::t('app', 'км/мес') ?></strong>
                    </li>
                </ul>
                <ul class="list car-date">
                    <li>
                        <span><?= Yii::t('app', 'Дата размещения') ?></span>
                        <strong><?= date('d.m.y', strtotime($model->published_at)) ?> <i class="far fa-calendar-alt"></i></strong>
                    </li>
                    <li>
                        <span><?= Yii::t('app', 'Просмотров') ?></span>
                        <strong><?= $model->views ?> <i class="far fa-eye"></i></strong>
                    </li>
                </ul>
            </div>
            <?php if(! empty( $model->description)):?>
            <p><?= $model->description ?></p>
            <div class="holder-box-hidden">
                <div class="box-hidden">
                    <?= $model->description ?>
                </div>
                <a class="btn-show-more" href="#">Читать дальше...</a>
            </div>
            <?php endif; ?>
            <div class="share">
                <span class="share-title"><?=\Yii::t('app', 'Поделиться') ?></span>
                <?= SocialShare::widget([
                    'configurator'  => 'socialShare',
                    'url'           => Url::to(Url::home(true).'advertisement/page/'.$model->id),
                    'title'         => $model->title,
                    'description'   => $model->description,
//                    'imageUrl'      => Url::to('@web'.$model->post_image, true),
                    'containerOptions' => [
                        'tag' => 'ul',
                        'class' => 'social-list'
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
<div class="holder-section fon-grey inner-grey relative">
    <div class="container">
        <div class="title-text">
            <h1><?= Yii::t('app', 'Рекомендованные объявления') ?></h1>
        </div>
        <?php if(! empty($similar)):?>
        <div class="slider-announcements">
            <ul class="list-announcements">
                <?php foreach ( $similar as $item):
                    $categories = Yii::createObject(Categories::className());
                    $categories->category = $item->category_id;
                    $cat  = $categories->category;
                    $images = (empty($item->images[0])) ? '/images/no-photo_item-small.png' : $item->images[0]['image_name'];
                    $images = Images::isThumbnailExists($images);
                    Images::isThumbnailExists($images);
                ?>
                    <li <?php if(Premium::checkPrem($item->id)): ?>class="premium"<?php endif; ?>>
                        <a class="like-star" href="<?= Url::toRoute('/myaccount/default/make-fav')?>" data-id="<?= $item->id ?>">&#160;</a>
                        <a href="<?= Url::to('/advertisement/page/'.$item->id)?>">
                            <div class="holder-img" style="background: url('<?= $images ?>') no-repeat center center; background-size: cover;">
                                <img src="/images/avatar-holder.png" alt="<?= (empty($item->images[0]['alt']) ? 'no-photo' : $item->images[0]['alt'])?>">
                            </div>
                            <div class="holder-text">
                                <span><?= $item->title ?></span>
                                <p><?= $cat->title ?></p>
                                <strong><?= $item->pricePerMonth ?> <sup><small><?= Yii::t('app', 'грн/мес') ?></small></sup></strong>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= FooterInfo::widget() ?>