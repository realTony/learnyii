<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="pages-form row">
    <div class="col-md-6">
        <div class="card bg-white m-b">
            <div class="card-block">
                <?= $form->field($model, 'title', [
                    'options' => [
                        'class' => 'form-group',
                        'tag' => 'div'
                    ]
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'options', [
                    'options' => [
                        'class' => 'form-group',
                        'tag' => 'div'
                    ]
                ])->textarea(['rows' => 6]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white m-b">
            <div class="card-block">
                <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>

<div class="seo-options row">

    <div class="col-md-6">
        <div class="card bg-white m-b">
            <div class="card-block">
                <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'seo_text')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'options')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'updated_at')->textInput() ?>

                <?= $form->field($model, 'created_at')->textInput() ?>
            </div>
        </div>
    </div>

</div>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
