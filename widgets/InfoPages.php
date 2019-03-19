<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 18.03.2019
 * Time: 19:31
 */

namespace app\widgets;


use app\models\Pages;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class InfoPages extends Widget
{

    public function run() : void
    {
        $pages = (new Pages())->find()->where(['not', ['link' => 'main']])->asArray()->all();
        $items = [];
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

        foreach ($pages as $page) {
            $title = $page['title'];
            $translation = (! empty($page['translation']))? json_decode($page['translation'], true) : [];
            $options = (! empty($page['options']))? json_decode($page['options'], true) : [];
            $title = ($currentLang == 'uk' && !empty($translation['title'])) ? $translation['title'] : $title;
            $item = ['label' => $title, 'url' => Url::to(['/'.$page['link']])];
            if( Url::current() == Url::to(['/'.$page['link']]) ) {
                $item['active'] = Url::current();
            }
            $items[] = $item;
        }
        ?>
        <div class="aside-right">
            <div class="aside">
                <span class="aside-title"><?= Yii::t('app','Информация') ?></span>
                <div class="aside-content">
                    <?= \yii\widgets\Menu::widget([
                        'options' => [
                            'class' => 'nav-aside',
                        ],
                        'items' => $items
                    ])?>
                </div>
            </div>
        </div>
        <?php
    }
}