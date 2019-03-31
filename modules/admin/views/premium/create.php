<?php


$this->title = Yii::t('app', 'Создать услугу');

echo $this->render('_form', [
   'model' => $model
]);