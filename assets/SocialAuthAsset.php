<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 12.02.2019
 * Time: 20:30
 */

namespace app\assets;


use yii\web\AssetBundle;

class SocialAuthAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/authchoice.js',
    ];
    public $depends = [
        'yii\authclient\widgets\AuthChoiceStyleAsset',
        'yii\web\YiiAsset',
    ];
}