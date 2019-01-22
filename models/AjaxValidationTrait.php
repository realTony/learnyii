<?php

namespace app\models;

use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;
use Yii;

trait AjaxValidationTrait
{
    /**
     * @param Model $model
     * @return array
     */
    protected function performAjaxValidation(Model $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}