<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 28.02.2019
 * Time: 17:20
 */

namespace app\widgets;


use Yii;
use yii\base\Widget;
use yii\widgets\ActiveForm;

class SortingForm extends Widget
{
    public $filter;
    public $viewButton = false;

    public function run()
    {
        ?>
        <div class="form-content">
            <?php $form = ActiveForm::begin([
                'id' => 'sortingForm',
                'method' => 'GET',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
            ]); ?>
            <fieldset>
                <div class="group">
                    <div class="holder-input">
                        <?= $form->field($this->filter,'city', ['options' => ['class' => 'city-input ui-widget', 'tag' => 'div']])
                            ->label(false)
                            ->textInput(['class' => 'tags-city', 'placeholder' => \Yii::t('app', 'Город'),  'name' => 'city'])?>
                        <?= $form->field($this->filter,'district', ['options' => ['class' => 'city-input ui-widget', 'tag' => 'div']])
                            ->label(false)
                            ->textInput(['class' => 'district', 'placeholder' => \Yii::t('app', 'Район'), 'name' => 'district'])?>
                    </div>
                    <?= $form->field($this->filter, 'orderBy', [
                        'options' => [
                            'class' => 'category-input',
                            'tag' => 'div'
                        ]
                    ])->label(false)->dropDownList([
                        'price_asc' => Yii::t('app', 'По возрастанию цены'),
                        'price_desc' => Yii::t('app', 'По убыванию цены'),
                        'popular' => Yii::t('app', 'По популярности')
                    ], ['class' => 'dropdown', 'name' => 'orderBy']) ?>
                </div>
            </fieldset>
            <?php ActiveForm::end(); ?>
            <? if( $this->viewButton ) : ?>
                <div class="holder-view">
                    <a class="view-list" href="#">
                        <i class="fas fa-th-large"></i>
                        <i class="fas fa-list"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php
    }
}