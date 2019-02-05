<?php

namespace app\modules\admin\ml_assets;

use yii\web\AssetBundle;


class AdminAssets extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/ml_assets';
    public $css = [
        'vendor/blueimp-file-upload/css/jquery.fileupload.css',
        'vendor/blueimp-file-upload/css/jquery.fileupload-ui.css',
        'vendor/summernote/dist/summernote.css',
        'vendor/bootstrap-daterangepicker/daterangepicker.css',
        'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
        'css/webfont.css',
        'css/climacons-font.css',
        'vendor/bootstrap/dist/css/bootstrap.css',
        'css/font-awesome.css',
        'css/card.css',
        'css/sli.css',
        'css/animate.css',
        'css/app.css',
        'css/app.skins.css',
    ];
    public $js = [
        'vendor/jquery.ui/ui/core.js',
        'vendor/jquery.ui/ui/widget.js',
        'vendor/jquery.ui/ui/mouse.js',
        'vendor/jquery.ui/ui/draggable.js',
        'vendor/jquery.ui/ui/sortable.js',
//        'http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js',
//        'http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js',
//        'http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js',
//        'http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js',
//        'vendor/blueimp-file-upload/js/jquery.iframe-transport.js',
//        'vendor/blueimp-file-upload/js/jquery.fileupload.js',
//        'vendor/blueimp-file-upload/js/jquery.fileupload-process.js',
//        'vendor/blueimp-file-upload/js/jquery.fileupload-image.js',
        'js/helpers/modernizr.js',
        'vendor/bootstrap/dist/js/bootstrap.js',
        'vendor/fastclick/lib/fastclick.js',
        'vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
        'js/helpers/smartresize.js',
        'js/constants.js',
        'js/main.js',
        'js/helpers/classie.js',
        'js/helpers/inputfx.js',
        'js/helpers/selectfx.js',
        'vendor/moment/min/moment.min.js',
        'vendor/bootstrap-daterangepicker/daterangepicker.js',
        'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'vendor/bootstrap-timepicker/js/bootstrap-timepicker.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}