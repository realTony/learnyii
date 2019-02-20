<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \app\modules\admin\models\Categories;

$categories = Yii::createObject(Categories::className());
$stickAreas = Yii::createObject(\app\models\StickingAreas::className());
$types = Yii::createObject(\app\models\AdvType::className());
$catList = array_merge([0 => Yii::t('app','Категория')], $categories->advertisement);
$subList = array_merge([0 => Yii::t('app', 'Подкатегория')], $categories->subAdvertisement);
$areas  = array_merge([0 => Yii::t('app', 'Область поклейки')], $stickAreas->stickingAreas);
$types  = array_merge([0 => Yii::t('app', 'Тип объявления')], $types->types);

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
        <h1>Создать объявление</h1>
    </div>
    <div class="group-content">
        <!-- User bar -->
        <div class="aside-left">
            <div class="aside-profile hide">
                <div class="seller clone">
                    <div class="holder-img">
                        <img src="<?= \app\models\Profile::getUserAvatar($user->id) ?>" alt="<?= $user->username ?>">
                    </div>
                    <div class="holder-text">
                        <a href="#" class="name"><?= $user->username ?></a>
                        <span><?= Yii::t('app','Дата регистрации') ?></span>
                        <span class="date"><?= date('d.m.Y', $user->created_at) ?></span>
                    </div>
                </div>
                <ul class="sub-nav">
                    <li>
                        <a href="#"><i class="fas fa-pencil-alt"></i> Редактировать профиль</a>
                    </li>
                    <li class="active">
                        <a href="#"><i class="fas fa-plus-circle"></i> Создать объявление</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-tags"></i> Мои объявления<sup><small>(12)</small></sup></a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-star"></i> Избранное</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-comments"></i> Сообщения </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- end User bar -->
        <div class="content">
            <?php $form = ActiveForm::begin([
                    'id' => 'createPost',
                    'options' => [
                        'class' => 'form-user'
                    ]
            ]); ?>
            <fieldset>
                <?= $form->field($model, 'title', ['options' => ['class' => 'holder-input', 'tag' => 'div']])->label(false)
                    ->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Заголовок'), 'class' => 'input']) ?>
                <ul class="input-list">

                    <?= $form->field($model, 'advertise_type', ['options' => ['class' => false, 'tag' => 'li']])
                        ->label(false)
                        ->dropDownList($types, ['class' => 'dropdown']) ?>

                    <?= $form->field($model, 'category_id', ['options' => ['class' => false, 'tag' => 'li']])
                        ->label(false)
                        ->dropDownList($catList, ['class' => 'dropdown']) ?>
                    <?= $form->field($model, 'subCat_id', ['options' => ['class' => false, 'tag' => 'li']])
                        ->label(false)
                        ->dropDownList($subList, ['class' => 'dropdown']) ?>
                </ul>
                <hr>
                <ul class="input-list">
                    <?= $form->field($model, 'sticking_area', ['options' => ['class' => false, 'tag' => 'li']])
                        ->label(false)
                        ->dropDownList($areas, ['class' => 'dropdown']) ?>
                    <?= $form->field($model, 'distancePerMonth', ['options' => ['class' => false, 'tag' => 'li']])
                        ->label(false)
                        ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Пробег (км/мес)'), 'class' => 'input']) ?>
                    <li class="empty"></li>
                </ul>
                <ul class="input-list">
                    <?= $form->field($model, 'contract_term', ['options' => ['class' => false, 'tag' => 'li']])
                        ->label(false)
                        ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Срок договора (мес)'), 'class' => 'input']) ?>
                    <?= $form->field($model, 'pricePerMonth', ['options' => ['class' => false, 'tag' => 'li']])
                        ->label(false)
                        ->textInput(['type' => 'number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Цена (грн/мес)'), 'class' => 'input']) ?>
                    <li>
                        <?= $form->field($model, 'coverage', ['options' => ['class' => 'checkbox'], 'template' => '<label>{input}<span><i class="fas fa-check"></i>{label}</span></label>{error}'] )
                            ->label(Yii::t('app', 'Полная обклейка'))->checkbox([], false) ?>

                    </li>
                </ul>
                <hr>
                <ul class="list-add-del">
                    <li>
                        <?= $form->field($model, 'city', ['options' => ['class' => 'holder-input', 'tag' => 'div']])
                            ->label(false)
                            ->textInput([ 'maxlength' => true, 'placeholder' => Yii::t('app', 'Город'), 'class' => 'input']) ?>
                        <?= $form->field($model, 'city_district', ['options' => ['class' => 'holder-input', 'tag' => 'div']])
                            ->label(false)
                            ->textInput([ 'maxlength' => true, 'placeholder' => Yii::t('app', 'Район'), 'class' => 'input']) ?>
                </ul>
                <hr>
                <?= $form->field($model, 'description', ['options' => ['class' => 'holder-area', 'tag' => 'div']])
                    ->label(false)
                    ->textarea(['placeholder' => Yii::t('app', 'Описание')]) ?>
                <hr>
                <ul class="list-img">
                    <li>
                        <a href="#" class="holder-img">
                            <i class="fas fa-times-circle"></i>
                            <img src="<?= Url::home(true)?>/images/bg-58.png" alt="img">
                        </a>
                    </li>
                    <li>
                        <a href="#" class="holder-img">
                            <i class="fas fa-times-circle"></i>
                            <img src="<?= Url::home(true)?>/images/bg-59.png" alt="img">
                        </a>
                    </li>
                    <li>
                        <a href="#" class="holder-img">
                            <i class="fas fa-times-circle"></i>
                            <img src="<?= Url::home(true)?>/images/bg-60.png" alt="img">
                        </a>
                    </li>
                    <li>
                        <div class="holder-file">
                            <input type="file" name="f" accept="image/*">
                            <a href="#"><img src="<?= Url::home(true)?>/images/bg-61.png" alt="img"></a>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="form-user-bottom">
                    <?= $form->field($model, 'show_email', ['options' => ['class' => 'checkbox'], 'template' => '<label>{input}<span><i class="fas fa-check"></i>{label}</span></label>{error}'] )
                        ->label(Yii::t('app', 'Показать электронную почту на странице объявления'))->checkbox([], false) ?>
                    <?= Html::submitButton(Yii::t('app', 'Cохранить'), ['class' => 'btn-orange']) ?>
                </div>
            </fieldset>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="accordion">
    <div class="holder-section">
        <div class="container">
            <div class="holder-box-hidden clone">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut nunc in eros posuere euismod in a tortor. Phasellus nunc orci, vehicula in <span class="box-hidden">hendrerit eu, hendrerit quis neque. Duis eget turpis nec enim vulputate tristique vel vel sem. Etiam sagittis facilisis nisl, id ultricies ante commodo vitae. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer nec elit sollicitudin, vehicula massa vel, accumsan dolor. Phasellus placerat quam justo, eu porttitor ante imperdiet a. Duis imperdiet, lacus at placerat bibendum, lacus arcu molestie lorem, sed lobortis dui nulla malesuada purus. Quisque id viverra lorem. Aliquam rutrum mattis varius. Aenean lectus mi, imperdiet aliquam imperdiet ac, pretium sed neque. Duis molestie luctus tellus sit amet eleifend. Curabitur erat nisl, sagittis non magna eget, sagittis malesuada urna. Etiam nibh justo, egestas et ligula at, molestie auctor tortor. Aliquam hendrerit ante sit amet urna congue ultrices. Vivamus pellentesque risus sit amet est pretium tristique.</span></p>
                <a class="btn-show-more" href="#">Читать дальше...</a>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Объявления в городах</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Интересные <br>предложения</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>