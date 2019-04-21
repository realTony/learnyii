<?php

use yii\helpers\Html;
use app\assets\AppAsset;

$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/png',
    'href' => '/favicon.png',
]);
AppAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="Content-Type" content="text/html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper">
    <header id="header">
        <div class="container">
            <?= $this->render('navbar_top.twig') ?>
        </div>
        <div class="holder-nav">
            <?= $this->render('main_navbar.twig') ?>
        </div>
    </header>
    <div id="main">
        <?= $content ?>
    </div>
</div>
<?= $this->render('footer.twig') ?>
<?php $this->endBody() ?>
<script>
    (function ($) {

        $('#login-form').on('submit', function(e) {
            e.preventDefault();
            //
            $('#login-form').data('yiiActiveForm').submitting = true;
            $('#login-form').yiiActiveForm('validate');
        });
    })(jQuery);
</script>
</body>
</html>
<?php $this->endPage() ?>
