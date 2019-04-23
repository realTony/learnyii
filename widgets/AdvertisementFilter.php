<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 24.02.2019
 * Time: 3:27
 */

namespace app\widgets;


use app\models\AdvertisementCatFilters;
use app\models\StickingAreas;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \app\modules\admin\models\Categories;

class AdvertisementFilter extends Widget
{
    public $options = [
            'show_filters' => false,
            'sub_only' => false,
            'cat_id' => '',
            'user_id' => false,
            'use_wrapper' => true,
            'custom_filters' => false
    ];
    public $filter;

    public function run()
    {
        if($this->options['user_id']) {
            $this->makeUserFilter();
        } else {
            $this->defaultFilter();
        }
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     *
     */
    public function makeUserFilter()
    {

        $cat = new Categories();
        $catList = $cat->advList;
        ?>
        <?php if( $this->options['use_wrapper'] == true): ?>
            <div class="aside-left">
        <?php endif; ?>
        <?php $form = ActiveForm::begin([
        'method' => 'GET',
        'options' => [
            'class' => 'holder-aside-left'
        ]
    ]);
        $stickingAreas = (new StickingAreas())->find()->all();
        $stickingAreas = ArrayHelper::map($stickingAreas, 'id', 'title');
        ?>
        <fieldset>
            <?php
            $current = '';
            if(! empty($this->options['user_id'])) {
                $catList = $cat->catByUser($this->options['user_id']);
            }
            if(! empty($catList) ):
                foreach ($catList as $id => $item):?>
                    <?php if(! empty($this->options['cat_id']) && $this->options['sub_only'] == true && $id != $this->options['cat_id'] ) {
                        continue;
                    }
                    $current = $item['title'];
                    ?>
                    <div class="aside-accordion">
                        <span class="title"><?= Yii::t('app', $item['title'] ) ?></span>
                        <div class="expanded">
                            <ul>
                                <?php foreach ($item['subList'] as $li => $val ):?>
                                    <?php
                                    $cat = new Categories();
                                    $cat->category = $li;
                                    $quantity = $cat->countUserCat($cat->category['id'], $this->options['user_id']);

                                    ?>
                                    <li><a href="<?= Url::to(['/'.$cat->category['link']]) ?>" class="pjax-buttons"><?= Yii::t('app', $cat->category->meta['title']) ?> <sup><small>(<?= $quantity ?>)</small></sup></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if($this->options['show_filters'] === true): ?>

                <div class="aside-accordion">
                    <span class="title"><?= Yii::t('app', 'Цена (грн/мес)')?></span>
                    <div class="expanded">
                        <div class="range-slider">
                            <div class="slider-range">
                                <input type="text" class="min_max_currentmin_currentmax" value="0/11000/<?= $this->filter['minPrice'].'/'.$this->filter['maxPrice']?>">
                                <?= $form->field($this->filter, 'minPrice', ['options' => ['id' => 'minDistance']])
                                    ->label(false)->textInput(['type'=> 'hidden', 'class' => 'minVal', 'name' => 'minPrice', 'value' => $this->filter['minPrice']])?>
                                <?= $form->field($this->filter, 'maxPrice', ['options' => ['id' => 'maxDistance']])
                                    ->label(false)->textInput(['type'=> 'hidden', 'class' => 'maxVal', 'name' => 'maxPrice','value' => $this->filter['maxPrice']])?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php if($current != 'Исполнители'): ?>
                    <div class="aside-accordion">
                        <span class="title"><?= Yii::t('app', 'Область поклейки') ?></span>
                        <div class="expanded">
                            <?=
                            $form->field($this->filter, 'stickingArea', [
                                'options' => [
                                    'tag' => 'ul',
                                    'class' => 'list-checkbox'
                                ]
                            ])
                                ->label(false)
                                ->checkboxList($stickingAreas, ['item' => function($index, $label, $name, $checked, $value){
                                    $checkedLabel = $checked ? 'checked' : '';
                                    $inputId = str_replace(['[', ']'], ['', ''], $name) . '_' . $index;

                                    return "<li><label  class='checkbox' for=$inputId>
                                    <input type='checkbox' name=$name value=$value id=$inputId $checkedLabel>
                                    <span><i class=\"fas fa-check\"></i> $label </span>
                                    </label></li>";
                                }, 'name' => 'stickingArea' ]);
                            ?>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title"><?= Yii::t('app', 'пробег (км/мес)')?></span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <?= $form->field($this->filter, 'minDistance', ['options' => ['id' => 'minDistance']])
                                        ->label(false)->textInput(['type'=> 'hidden', 'class' => 'minVal', 'name' => 'minDistance', 'value' => $this->filter['minDistance']]) ?>
                                    <?= $form->field($this->filter, 'maxDistance', ['options' => ['id' => 'maxDistance']])
                                        ->label(false)->textInput(['type'=> 'hidden', 'class' => 'maxVal', 'name' => 'maxDistance', 'value' => $this->filter['maxDistance']]) ?>
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/2000/<?= $this->filter['minDistance'].'/'.$this->filter['maxDistance']?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?= Html::submitButton(Yii::t('app', 'Применить'), ['class' => 'submit']); ?>
            <?php endif; ?>
        </fieldset>
        <?php ActiveForm::end(); ?>

        <?php if( $this->options['use_wrapper'] == true):?>
        </div>
    <?php endif; ?>
        <?php
    }

    public function defaultFilter()
    {

        $cat = new Categories();
        $catList = $cat->advList;
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

        ?>
        <?php if( $this->options['use_wrapper'] == true):?>
            <div class="aside-left">
        <?php endif; ?>
        <?php $form = ActiveForm::begin([
        'method' => 'GET',
        'options' => [
            'class' => 'holder-aside-left'
        ]
    ]);
        $stickingAreas = (new StickingAreas())->find()->all();
        $stickingAreas = ArrayHelper::map($stickingAreas, 'id', 'title');

        ?>
        <fieldset>
            <?php
            $current = '';

            foreach ($catList as $id => $item):?>
                <?php if(! empty($this->options['cat_id']) && $this->options['sub_only'] == true && $id != $this->options['cat_id'] ) {
                    continue;
                }

                $category = new Categories();
                $data = $category->findOne($id);
                $current = $data->meta['title'];
                $options = json_decode($data->options, true);
                $translation = json_decode($data->translation, true);
                $extraFilter = (new AdvertisementCatFilters())->find()->where(['category_id' => $id])->all();
                if( !empty($this->options['sub_only']) && $this->options['sub_only'] == true) {

                    if( $currentLang == 'ru' ) {

                        $extraFilter = ArrayHelper::map($extraFilter, 'id', 'filter_name');
                        $current = (!empty($options['custom_title'])) ? $options['custom_title'] : $current;
                    } else {

                        $extraFilter = ArrayHelper::map($extraFilter, 'id', 'filter_translation');
                        $current = (!empty($translation['custom_title'])) ? $translation['custom_title'] : $current;
                    }
                 }

                if( ! empty($this->options['cat_id']) && $this->options['sub_only'] == true && $options['use_filters'] == 1) {
                    $this->options['custom_filters'] = true;
                }
                ?>
                <div class="aside-accordion">
                    <?php

                    if( $this->options['custom_filters'] == true ) {
                        if ( $item['title'] == 'Реклама' ) {
                            $item['title']  = Yii::t('app', 'Область поклейки');
                        }
                        if ( $item['title'] == 'Транспорт' ) {
                            $item['title']  = Yii::t('app', 'Виды транспорта');
                        }
                        if ( $item['title'] == 'Исполнители' ) {
                            $item['title']  = Yii::t('app', 'Исполнители');
                        }
                    }
                    ?>
                    <span class="title"><?= Yii::t('app', $item['title'] ) ?></span>

                    <div class="expanded">
                            <ul>
                                <?php foreach ($item['subList'] as $li => $val ):?>
                                    <?php
                                    $cat = new Categories();
                                    $cat->category = $li;
                                    $quantity = $cat->advertisementCount;

                                    ?>
                                    <li><a href="<?= Url::to(['/'.$cat->category['link']]) ?>"><?= Yii::t('app', $cat->category->meta['title']) ?> <sup><small>(<?= $quantity ?>)</small></sup></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                </div>
            <?php endforeach; ?>

            <?php if($this->options['show_filters'] === true): ?>

                <div class="aside-accordion">
                    <span class="title"><?= Yii::t('app', 'Цена (грн/мес)')?></span>
                    <div class="expanded">
                        <div class="range-slider">
                            <div class="slider-range">
                                <input type="text" class="min_max_currentmin_currentmax" value="0/11000/<?= $this->filter['minPrice'].'/'.$this->filter['maxPrice']?>">
                                <?= $form->field($this->filter, 'minPrice', ['options' => ['id' => 'minDistance']])
                                    ->label(false)->textInput(['type'=> 'hidden', 'class' => 'minVal', 'name' => 'minPrice', 'value' => $this->filter['minPrice']])?>
                                <?= $form->field($this->filter, 'maxPrice', ['options' => ['id' => 'maxDistance']])
                                    ->label(false)->textInput(['type'=> 'hidden', 'class' => 'maxVal', 'name' => 'maxPrice','value' => $this->filter['maxPrice']])?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php if($this->options['cat_id'] != 10): ?>
                    <div class="aside-accordion">
                        <?php if(! empty($current)): ?>
                        <span class="title"><?= Yii::t('app', $current ) ?></span>
                        <?php else : ?>
                        <span class="title"><?= Yii::t('app', 'Область поклейки') ?></span>
                        <?php endif; ?>
                            <div class="expanded">
                                <?=
                                $form->field($this->filter, 'extraFilter', [
                                    'options' => [
                                        'tag' => 'ul',
                                        'class' => 'list-checkbox'
                                    ]
                                ])
                                    ->label(false)
                                    ->checkboxList($extraFilter, ['item' => function($index, $label, $name, $checked, $value){
                                        $checkedLabel = $checked ? 'checked' : '';
                                        $inputId = str_replace(['[', ']'], ['', ''], $name) . '_' . $index;

                                        return "<li><label  class='checkbox' for=$inputId>
                                    <input type='checkbox' name=$name value=$value id=$inputId $checkedLabel>
                                    <span><i class=\"fas fa-check\"></i> $label </span>
                                    </label></li>";
                                    }, 'name' => 'extraFilter' ]);
                                ?>
                            </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title"><?= Yii::t('app', 'пробег (км/мес)')?></span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <?= $form->field($this->filter, 'minDistance', ['options' => ['id' => 'minDistance']])
                                        ->label(false)->textInput(['type'=> 'hidden', 'class' => 'minVal', 'name' => 'minDistance', 'value' => $this->filter['minDistance']]) ?>
                                    <?= $form->field($this->filter, 'maxDistance', ['options' => ['id' => 'maxDistance']])
                                        ->label(false)->textInput(['type'=> 'hidden', 'class' => 'maxVal', 'name' => 'maxDistance', 'value' => $this->filter['maxDistance']]) ?>
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/2000/<?= $this->filter['minDistance'].'/'.$this->filter['maxDistance']?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?= Html::submitButton(Yii::t('app', 'Применить'), ['class' => 'submit']); ?>
            <?php endif; ?>
        </fieldset>
        <?php ActiveForm::end(); ?>

        <?php if( $this->options['use_wrapper'] == true):?>
        </div>
    <?php endif; ?>
        <?php
    }

}