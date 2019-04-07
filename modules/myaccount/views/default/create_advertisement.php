<?php

use app\widgets\FooterInfo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Categories;
use app\models\Cities;
use app\widgets\UserBar;

$categories = Yii::createObject(Categories::className());
$stickAreas = Yii::createObject(\app\models\StickingAreas::className());
$types = Yii::createObject(\app\models\AdvType::className());
$catList = $categories->advertisement;
$subList = $categories->subAdvertisement;
$areas  = $stickAreas->stickingAreas;
$types  =  $types->types;
$currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
?>
<?= \app\widgets\SearchAdverts::widget()?>
    <div class="holder-crumbs">
        <div class="container">
            <?= \yii\widgets\Breadcrumbs::widget([
                'links' => $breadcrumbs,
                'options'=> [
                    'class' => 'bread-crumbs'
                ]
            ]) ?>
        </div>
    </div>
    <div class="container">
        <div class="title-text clone">
            <h1><?= $this->title ?></h1>
        </div>
        <div class="group-content">
            <!-- User bar -->
            <?= UserBar::widget([
                'user' => $user
            ])?>
            <!-- end User bar -->
            <?= $this->render('_form.php', [
                'model' => $model,
                'lang' => $currentLang
            ]);
            ?>
        </div>
    </div>
<?//= FooterInfo::widget(); ?>