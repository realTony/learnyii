<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 23.02.2019
 * Time: 13:33
 */

namespace app\widgets;


use app\models\AdvertisementPost;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Profile;

class UserBar extends Widget
{
    public $user;
    public $options = [
            'public_bar' => false,
            'has_wrapper' => true,
            'profileClass' => 'aside-profile ghost',
            'enableMenu' => true
    ];

    public function run()
    {
        if(empty($this->options) || empty($this->options['public_bar']) || ! $this->options['public_bar']):

            if($this->options['has_wrapper']) {
                echo Html::beginTag('div', ['class' => 'aside-left']);
            }

            echo Html::beginTag('div', ['class' => $this->options['profileClass']]);
                echo Html::beginTag('div', ['class' => ($this->options['has_wrapper']) ? 'seller clone': 'seller']);
                ?>
                    <div class="holder-img">
                        <img src="<?= Profile::getUserAvatar( Yii::$app->user->id) ?>" alt="profile_image">
                    </div>
                    <div class="holder-text">
                        <a href="<?= Url::toRoute('/myaccount') ?>" class="name"><?= $this->user['username'] ?></a>
                        <span><?= Yii::t('app','Дата регистрации')?></span>
                        <span class="date"><?= date('d.m.Y', $this->user['created_at']) ?></span>
                    </div>
                <?php
                echo Html::endTag('div');

            if( $this->options['enableMenu']):
                ?>
                <ul class="sub-nav">
                    <li class="active">
                        <a href="<?= Url::toRoute('/myaccount/edit') ?>"><i class="fas fa-pencil-alt"></i><?= Yii::t('app','Редактировать профиль')?></a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute('/myaccount/create') ?>"><i class="fas fa-plus-circle"></i><?= Yii::t('app','Создать объявление')?></a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute('/myaccount/posts') ?>"><i class="fas fa-tags"></i><?= Yii::t('app','Мои объявления')?> <sup><small>(<?= (new AdvertisementPost)->advCount ?>)</small></sup></a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-star"></i> Избранное</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-comments"></i> Сообщения </a>
                    </li>
                </ul>
                <?php
                else:
                ?>
                    <div class="accordion-inform">
<!--                        <div class="item">-->
<!--                            <div class="holder-block">-->
<!--                                <strong class="heading">--><?//= Yii::t('app', 'Контактная информация') ?><!--</strong>-->
<!--                                <div class="expanded">-->
<!--                                    <span class="title">--><?//= Yii::t('app', 'Контактная информация') ?><!--</span>-->
<!--                                    <ul class="list-contakt">-->
<!--                                        --><?php //if(! empty($profile->phone)):?>
<!--                                            <li>-->
<!--                                                <i class="fas fa-phone"></i> <a href="tel:--><?//= $profile->phone ?><!--">--><?//= $profile->phone ?><!--</a>-->
<!--                                            </li>-->
<!--                                        --><?php //endif; ?>
<!--                                        --><?php //if(! empty($profile->viber)):?>
<!--                                            <li>-->
<!--                                                <i class="fab fa-viber"></i> <a href="viber://chat?number=--><?//= $profile->viber ?><!--">--><?//= $profile->viber ?><!--</a>-->
<!--                                            </li>-->
<!--                                        --><?php //endif; ?>
<!--                                        --><?php //if(! empty($profile->telegram)):?>
<!--                                            <li>-->
<!--                                                <i class="fab fa-telegram-plane"></i> <a href="tg://--><?//= $profile->telegram ?><!--">--><?//= $profile->telegram ?><!--</a>-->
<!--                                            </li>-->
<!--                                        --><?php //endif; ?>
<!--                                        --><?php //if(! empty($profile->whatsapp)):?>
<!--                                            <li>-->
<!--                                                <i class="fab fa-whatsapp"></i> <a href="https://wa.me/--><?//= $profile->whatsapp ?><!--">--><?//= $profile->whatsapp ?><!--</a>-->
<!--                                            </li>-->
<!--                                        --><?php //endif; ?>
<!--                                        --><?php //if(! empty($model->showEmail) && $model->showEmail):?>
<!--                                            <li>-->
<!--                                                <i class="far fa-envelope"></i> <a href='mailto:--><?//= $user->email ?><!--'>--><?//= $user->email ?><!--</a>-->
<!--                                            </li>-->
<!--                                        --><?php //endif; ?>
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="item">
                            <span class="title visible"><?= Yii::t('app', 'Контактная информация') ?></span>
                            <ul class="list-contakt">
                                <li>
                                    <i class="fas fa-phone"></i> <a href="tel:(096) 925-99-56">(096) 925-99-56</a>
                                </li>
                                <li>
                                    <i class="fab fa-viber"></i> <a href="viber://chat?number=3800969259956">(096) 925-99-56</a>
                                </li>
                                <li>
                                    <i class="fab fa-telegram-plane"></i> <a href="tg://breyger">breyger</a>
                                </li>
                                <li>
                                    <i class="fab fa-viber"></i> <a href="viber://chat?number=3800969259956">(096) 925-99-56</a>
                                </li>
                                <li>
                                    <i class="far fa-envelope"></i> <a href='mailto&#58;&#98;r%6&#53;&#37;79ge&#114;&#64;g&#109;%&#54;1i%&#54;C&#46;co&#109;'>br&#101;&#121;&#103;er&#64;gmail&#46;com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                endif;
            echo Html::endTag('div');

            if($this->options['has_wrapper']) {
                echo Html::endTag('div');
            }

        endif;
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }
}