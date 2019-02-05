<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BlogPosts */

$this->title = Yii::t('app', 'Создать новость');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Блог'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="m-b-lg text-center"><?= Html::encode($this->title) ?></h2>
    </div>
</div>
<?= $this->render('_form', [
    'model' => $model,
    'categories' => $categories
]) ?>
