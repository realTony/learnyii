<?php

use app\widgets\FooterInfo;
use app\widgets\InfoPages;
use app\widgets\SearchAdverts;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

echo SearchAdverts::widget();
$this->params['breadcrumbs'] = $breadcrumbs;
?>

<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <?php
            echo Breadcrumbs::widget([
                'options' => [
                    'class' => 'bread-crumbs'
                ],
                'itemTemplate' => "<li>{link}</li>\n", // template for all links
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="group-content revers">
        <?= InfoPages::widget() ?>
        <div class="content">
            <div class="title-text">
                <h1><?= $model->title ?></h1>
            </div>
            <?php if(! empty($model->options->content)): ?>
            <?= $model->options->content ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= FooterInfo::widget() ?>