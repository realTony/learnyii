<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use yii\widgets\LinkPager;
use app\components\TextExcerption;

$this->params['breadcrumbs'] = $breadcrumbs;

?>
<div class="form-search">
    <div class="container">
        <a class="search-query" href="#">Поисковый запрос</a>
        <div class="holder-form-search">
            <span class="bg-search"></span>
            <form>
                <fieldset>
                    <a class="closed-search-form" href="#"></a>
                    <div class="search-input">
                        <input type="text" placeholder="Поисковый запрос">
                    </div>
                    <div class="category-input">
                        <select name="dropdown" class="dropdown">
                            <option>Категория</option>
                            <option>Категория1</option>
                            <option>Категория2</option>
                            <option>Категория3</option>
                        </select>
                    </div>
                    <div class="city-input ui-widget">
                        <input class="tags-city" type="text" placeholder="Город">
                    </div>
                    <input class="btn-search" type="submit" value="искать">
                </fieldset>
            </form>
        </div>
    </div>
</div>
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
                    foreach ($models as $model) {
                        ?>
                            <li class="grid-item">
                            <?php if(! empty($model->post_thumbnail) ): ?>
                                <div class="holder-img">
                                        <img src="<?= (! empty($model->post_thumbnail))? $model->post_thumbnail: $model->post_image ?>" alt="<?= $model->title ?>_image">
                                </div>
                            <?php endif;?>
                            <div class="holder-text">
                                <a class="title-link" href="<?= Url::toRoute($model->link)?>"><?= $model->title ?></a>
                                <p><?= TextExcerption::excerptText($model->description, 110); ?></p>
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