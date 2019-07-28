<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fonts/stylesheet.css',
        'css/jquery-ui.css',
        'css/site.css',
        'css/slick.css',
        'css/dropdown.css',
        'css/all.css',
        'css/cropper.min.css',
        'https://use.fontawesome.com/releases/v5.5.0/css/all.css',
    ];
    public $js = [
        'js/libs/slick.min.js',
        'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
        'js/libs/jquery.ui.touch-punch.js',
        'js/libs/core.js',
        'js/libs/dropdown.js',
        'js/libs/jquery.matchHeight.js',
        'js/libs/isotope.pkgd.min.js',
        'js/cropper.min.js',
        'js/jquery.main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
