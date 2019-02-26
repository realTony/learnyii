<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 24.02.2019
 * Time: 3:27
 */

namespace app\widgets;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class AdvertisementFilter extends Widget
{
    public $options;

    public function run()
    {
        ?>
            <div class="aside-left">
                <?php $form = ActiveForm::begin(); ?>
<!--                <form class="holder-aside-left">-->
                <fieldset>
                    <div class="aside-accordion">
                        <span class="title">Транспорт</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Легковые автомобили <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Мото <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Прицепы <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Грузовики <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Автобусы <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Велосипеды <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Другое <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Реклама</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Полная обклейка <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Частичная обклейка <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Навесная реклама <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Реклама в салоне <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Исполнители</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Типографии <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Дизайнеры <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Поклейщики <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Цена (грн/мес)</span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/11000/1600/10000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Область поклейки</span>
                        <div class="expanded">
                            <ul class="list-checkbox">
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Полная обклейка</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n" checked>
                                        <span><i class="fas fa-check"></i> Частичная обклейка</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Навесная реклама</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Реклама в салоне</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">пробег (км/мес)</span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/2000/300/1000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= Html::submitButton(Yii::t('app', 'Применить'), ['class' => 'submit']); ?>
                </fieldset>
                <?php ActiveForm::end(); ?>
<!--            </form>-->
            </div>
        <?php
    }

}