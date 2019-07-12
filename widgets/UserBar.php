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
        $profile = (new Profile())->findOne(['user_id' => $this->user->id]);
        if(empty($this->options) || empty($this->options['public_bar']) || ! $this->options['public_bar']):

            if($this->options['has_wrapper']) {
                echo Html::beginTag('div', ['class' => 'aside-left']);
            }

            echo Html::beginTag('div', ['class' => $this->options['profileClass']]);
                echo Html::beginTag('div', ['class' => ($this->options['has_wrapper']) ? 'seller clone': 'seller']);
                ?>
                    <div class="holder-img" style="background: url('<?= Profile::getUserAvatar( $this->user->id) ?>') no-repeat center center; background-size:cover; ">
                        <img src="/images/avatar-holder.png" alt="image holder">
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
                    <li <?php if(Url::toRoute('/'.Yii::$app->requestedRoute) == Url::toRoute('/myaccount/edit') ): ?> class="active" <?php endif; ?> >
                        <a href="<?= Url::toRoute('/myaccount/edit') ?>"><i class="fas fa-pencil-alt"></i><?= Yii::t('app','Редактировать профиль')?></a>
                    </li>
                    <li <?php if(Url::toRoute('/'.Yii::$app->requestedRoute) == Url::toRoute('/myaccount/create') ): ?> class="active" <?php endif; ?> >
                        <a href="<?= Url::toRoute('/myaccount/create') ?>"><i class="fas fa-plus-circle"></i><?= Yii::t('app','Создать объявление')?></a>
                    </li>
                    <li <?php if(Url::toRoute('/'.Yii::$app->requestedRoute) == Url::toRoute('/myaccount/posts') ): ?> class="active" <?php endif; ?>>
                        <a href="<?= Url::toRoute('/myaccount/posts') ?>"><i class="fas fa-tags"></i><?= Yii::t('app','Мои объявления')?> <sup><small>(<?= (new AdvertisementPost)->advCount ?>)</small></sup></a>
                    </li>
                    <li <?php if(Url::toRoute('/'.Yii::$app->requestedRoute) == Url::toRoute('/myaccount/favorites') ): ?> class="active" <?php endif; ?>>
                        <a href="<?= Url::toRoute('/myaccount/favorites') ?>"><i class="fas fa-star"></i> <?= Yii::t('app', 'Избранное') ?></a>
                    </li>

<!--                    <li>-->
<!--                        <a href="#"><i class="fas fa-comments"></i> Сообщения </a>-->
<!--                    </li>-->
                </ul>
                <?php
                else:
                ?>
                    <div class="accordion-inform">
                    <?php if(Yii::$app->user->isGuest) : ?>
                        <div class="item">
                            <span class="title visible"><?= Yii::t('app', 'Контактная информация') ?></span>
                            <ul class="list-contakt">
                                <li>
                                    <a  href="<?= Url::toRoute(['/account#login']) ?>"><?= Yii::t('app', 'Для просмотра необходимо войти в учётную запись') ?> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="item">
                            <span class="title visible"><?= Yii::t('app', 'Контактная информация') ?></span>
                            <ul class="list-contakt">
                                <?php if(! empty($profile->phone)):?>
                                    <li>
                                        <i class="fas fa-phone"></i> <a href="tel:<?= $profile->phone ?>"><?= $profile->phone ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(! empty($profile->viber)):?>
                                    <li>
                                        <i class="fab fa-viber"></i> <a href="<?= $profile->viber ?>"><?= $profile->viber ?></a>
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
                                    <li>
                                        <i class="far fa-envelope"></i> <a href='mailto:<?= $this->user->email ?>'><?=$this->user->email ?></a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
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