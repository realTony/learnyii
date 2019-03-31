<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Редактировать услугу');
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php
echo $this->render('_form', [
    'model' => $model
]);