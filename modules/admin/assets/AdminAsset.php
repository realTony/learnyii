<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 18.01.2019
 * Time: 3:07
 */

namespace app\modules\admin\assets;


use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/themify-icons.css',
        'css/metisMenu.css',
        'css/owl.carousel.min.css',
        'css/slicknav.min.css',
        'https://www.amcharts.com/lib/3/plugins/export/export.css',
        'css/typography.css',
        'css/default-css.css',
        'css/styles.css',
        'responsive.css'
    ];
    public $js = [
        'js/vendor/jquery-2.2.4.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/owl.carousel.min.js',
        'js/metisMenu.min.js',
        'js/jquery.slimscroll.min.js',
        'js/jquery.slicknav.min.js',
        'js/plugins.js',
        'js/scripts.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}