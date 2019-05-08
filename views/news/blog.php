<?php

use app\components\Images;
use app\widgets\FooterInfo;
use app\widgets\SearchAdverts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use yii\widgets\LinkPager;
use app\components\TextExcerption;

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
            <div class="holder-aside-right">
                <span class="aside-title"><?= Yii::t('app', 'Категории') ?></span>
                <div class="aside-content">
                    <?php
                    echo Menu::widget([
                        'options' => [
                            'class' => 'nav-aside'
                        ],
                        'items' => $categories,
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="title-text">
                <h1><?= Yii::t('app', 'Новости')?></h1>
            </div>
            <ul class="blog-list">
                <li class="grid-sizer"></li>
                <?php
                    $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
                    foreach ($models as $model) {
                        $title = '';
                        $description = '';
                        $options = json_decode($model->options, true);
                        $translation = json_decode($model->translation, true);

                        $title = ($currentLang == 'uk' && !empty($translation['title'])) ? $translation['title'] : $model->title;
                        $description = ($currentLang == 'uk' && !empty($translation['description'])) ? $translation['description'] : $model->description;
                        ?>
                            <li class="grid-item">
                                <?php if(! empty($model->post_thumbnail) ): ?>
                                <?php
                                    $model->post_thumbnail = Images::isThumbnailExists($model->post_thumbnail);
                                ?>
                                    <div class="holder-img">
                                        <img src="<?= (! empty($model->post_thumbnail))? $model->post_thumbnail: $model->post_image ?>" alt="<?= $title ?>_image">
                                    </div>
                                <?php endif;?>
                                <div class="holder-text">
                                    <a class="title-link" href="<?= Url::toRoute($model->link)?>"><?= $title ?></a>
                                    <p><?= TextExcerption::excerptText(Html::encode($description), 110); ?></p>
                                    <a href="<?= Url::toRoute($model->link) ?>"><?= Yii::t('app', 'Читать полностью') ?></a>
                                </div>
                            </li>
                        <?php
                    }
                ?>
            </ul>

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
        </div>
    </div>
</div>

<?= FooterInfo::widget() ?>