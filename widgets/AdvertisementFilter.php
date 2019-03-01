<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 24.02.2019
 * Time: 3:27
 */

namespace app\widgets;


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
    public $options;
    public $filter;

    public function run()
    {
        $cat = new Categories();
        $catList = $cat->advList;
        ?>
            <div class="aside-left">
                <?php $form = ActiveForm::begin([
                        'options' => [
                                'class' => 'holder-aside-left'
                        ]
                ]);
                $stickingAreas = (new StickingAreas())->find()->all();
                $stickingAreas = ArrayHelper::map($stickingAreas, 'id', 'title');
                ?>
                <fieldset>
                    <?php foreach ($catList as $item):?>
                        <div class="aside-accordion">
                            <span class="title"><?= $item['title'] ?></span>
                            <div class="expanded">
                                <ul>
                                    <?php foreach ($item['subList'] as $li => $val ):?>
                                    <?php
                                        $cat = new Categories();
                                        $cat->category = $li;
                                        $quantity = $cat->advertisementCount;

                                    ?>
                                        <li><a href="<?= Url::to(['/'.$cat->category['link']]) ?>"><?= $val ?> <sup><small>(<?= $quantity ?>)</small></sup></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
                    <?= Html::submitButton(Yii::t('app', 'Применить'), ['class' => 'submit']); ?>
                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
        <?php
    }

}