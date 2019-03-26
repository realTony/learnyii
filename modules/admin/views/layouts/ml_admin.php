<?php

use yii\helpers\Url;
use app\modules\admin\ml_assets\AdminAssets;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AdminAssets::register($this);

$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::home(true).'favicon.png']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="page-loading">
<!-- page loading spinner -->
<div class="pageload">
    <div class="pageload-inner">
        <div class="sk-rotating-plane"></div>
    </div>
</div>
<!-- /page loading spinner -->
<div class="app layout-fixed-header">
    <!-- sidebar panel -->
    <div class="sidebar-panel offscreen-left">
        <div class="brand">
            <!-- toggle offscreen menu -->
            <div class="toggle-offscreen">
                <a href="javascript:;" class="visible-xs hamburger-icon" data-toggle="offscreen" data-move="ltr">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>
            <!-- /toggle offscreen menu -->
            <!-- logo -->
            <a class="brand-logo" href="<?= Url::home(true) ?>admin">
                <span><?= Yii::$app->name ?> Admin</span>
            </a>
            <a href="<?= Url::home(true) ?>admin" class="small-menu-visible brand-logo">S</a>
            <!-- /logo -->
        </div>
        <!-- main navigation -->
        <?= $this->render('_menu', ['menu' => \Yii::$app->view->params['menu'] ] ) ?>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar panel -->
    <!-- content panel -->
    <?= $this->render('_main-panel', [
            'content' => $content
    ] ) ?>
    <!-- /content panel -->
    <!-- bottom footer -->
    <?= $this->render('_footer') ?>
    <!-- /bottom footer -->
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
</div>

<?php $this->beginBody() ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
