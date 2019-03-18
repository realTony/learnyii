<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="main-panel">
    <!-- top header -->
    <div class="header navbar">
        <div class="brand visible-xs">
            <!-- toggle offscreen menu -->
            <div class="toggle-offscreen">
                <a href="javascript:;" class="hamburger-icon visible-xs" data-toggle="offscreen" data-move="ltr">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>
            <!-- /toggle offscreen menu -->
            <!-- logo -->
            <a class="brand-logo">
                <span><?= Yii::$app->name ?></span>
            </a>
            <!-- /logo -->
        </div>
        <ul class="nav navbar-nav hidden-xs">
            <li>
                <a href="javascript:;" class="small-sidebar-toggle ripple" data-toggle="layout-small-menu">
                    <i class="icon-toggle-sidebar"></i>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right hidden-xs">

            <li>
                <a href="javascript:;" class="ripple" data-toggle="dropdown">
                    <div class="header-avatar img-circle" style="background: url('<?= app\models\Profile::getUserAvatar(\Yii::$app->user->id) ?>') no-repeat center center; background-size: cover;"></div>
                    <span><?= \Yii::$app->user->identity->username ?></span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:;">Настройки</a>
                    </li>
                    <li>
                        <?php $form = ActiveForm::begin([
                                'id' => 'logout-form',
                                'method' => 'POST',
                                'action' => Url::to('/site/logout')
                        ])?>
                        <?= Html::submitButton(Yii::t('app', 'Выйти'), ['id' => 'logout', 'style' => 'display:none']) ?>
                        <a id='user_logout' href=""><?= (Yii::t('app', 'Выйти')) ?></a>
                        <?php ActiveForm::end() ?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /top header -->
    <!-- main area -->
    <div class="main-content">
        <!-- page title -->
        <div class="page-title">
            <div class="title"><?= $this->title ?></div>
        </div>
        <!--end  page title -->

<!--        <div class="row">-->
<!--            <div class="col-md-12">-->
<!--                <h2>Главная страница</h2>-->
<!--            </div>-->
<!--        </div>-->
        <div class="row">
            <div class="col-md-12">
                <?= $content ?>
            </div>
        </div>
    </div>
    <!-- /main area -->
</div>