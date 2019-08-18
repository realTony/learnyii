<?php
namespace app\widgets;


use app\models\AdvertiseCitiesRegions;
use app\models\AdvertisementPost;
use yii\base\Widget;

class FooterInfo extends Widget
{
    public $options = [
        'has_seo' => true
    ];

    public $seo_text;

    public function run() : void
    {
        if( $this->options['has_seo'] == true) {
            $this->showDefaultFooter();
        } else {
            $this->showCustomFooter();
        }
    }

    public function showDefaultFooter() : void
    {

        $citiesPosts = new AdvertiseCitiesRegions();
        $interestingAdv = new AdvertisementPost();
        ?>
        <div class="accordion">
            <div class="holder-section">
                <div class="container">
                    <?php if( !empty( $this->seo_text)): ?>
                    <div class="holder-box-hidden clone">
                        <?= $this->seo_text ?>
                        <a class="btn-show-more" href="#"><?= \Yii::t('app', 'Читать дальше...')?></a>
                    </div>
                    <?php endif; ?>
                    <div class="adver-group">
                        <div class="item-accordion">
                            <div class="advert">
                                <strong class="btn-accordion"><?= \Yii::t('app', 'Объявления в городах')?></strong>
                            </div>
                            <?php if(! empty($citiesPosts->citiesList)): ?>
                                <div class="holder-text content-accordion">
                                    <p><?= $citiesPosts->links ?>. </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="adver-group">
                        <div class="item-accordion">
                            <?php if(! empty($interestingAdv->interesting)): ?>
                                <div class="advert">
                                    <strong class="btn-accordion"><?= \Yii::t('app', 'Интересные <br>предложения')?></strong>
                                </div>
                                <div class="holder-text content-accordion">
                                    <p><?= $interestingAdv->interesting ?>. </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function showCustomFooter() : void
    {


        $citiesPosts = new AdvertiseCitiesRegions();
        $interestingAdv = new AdvertisementPost();
        ?>
            <div class="holder-section">
                <div class="container">
                    <div class="adver-group">
                        <div class="item-accordion">
                            <?php if(! empty($citiesPosts->citiesList)): ?>
                                <div class="advert">
                                    <strong class="btn-accordion"><?= \Yii::t('app', 'Объявления в городах')?></strong>
                                </div>
                                <div class="holder-text content-accordion">
                                    <p><?= $citiesPosts->links ?>. </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="adver-group">
                        <div class="item-accordion">
                            <?php if(! empty($interestingAdv->interesting)): ?>
                            <div class="advert">
                                <strong class="btn-accordion"><?= \Yii::t('app', 'Интересные <br>предложения')?></strong>
                            </div>
                            <div class="holder-text content-accordion">
                                <p><?= $interestingAdv->interesting ?>. </p>
                             </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php
    }
}