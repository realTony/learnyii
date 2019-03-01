<?php

namespace app\widgets;


use app\models\Settings;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SocialList extends Widget
{

    //https://t.me/Elmir_UA_official
    //facebook
    //instagram
    //viber://contact?number=+380661285651
    public $options =  [];
    public $containerOptions = [
            'tag' => '',
            'class' => ''
    ];
    public $socialNetworks = [
            'site_telegram' => [
                'class' => 'fa-telegram-plane',
                'url' => 'https://t.me/'
            ],
            'site_facebook' => [
                'class' => 'fa-facebook-f',
                'url' => ''
            ],
            'site_instagram' => [
                'class' => 'fa-instagram',
                'url' => ''
            ],
            'site_viber' => [
                'class' => 'fa-viber',
                'url' => 'viber://chat?number=%2B'
            ]
    ];

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $tag = ArrayHelper::remove($this->containerOptions, 'tag');
        if (! empty($tag)) {
            echo Html::beginTag($tag, $this->containerOptions);
        }
    }

    public function run()
    {
        $tag = ArrayHelper::remove($this->containerOptions, 'tag');
        $networks = Yii::createObject(Settings::className())
                    ->find()
                    ->where(['in', 'name', array_keys($this->socialNetworks)])
                    ->all();
        if (! empty($networks)):
            echo Html::beginTag('ul',['class' => 'social']);

            foreach ($networks as $link) {
                if (! empty($link['option_value'])) {
                    echo Html::beginTag('li');
                    echo Html::a(Html::tag('i','', [
                            'class' => 'fab '.$this->socialNetworks[$link['name']]['class']
                        ]
                    ), $this->socialNetworks[$link['name']]['url'].$link['option_value'], [
                        'target' => '_blank',
                        'class' => 't-icon'
                    ]);
                    echo Html::endTag('li');
                }
            }

            echo Html::endTag('ul');
        ?>
        <?php
        endif;
        if (! empty($tag)) {
            echo Html::endTag($tag);
        }
    }
}