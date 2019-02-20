<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 17.02.2019
 * Time: 23:36
 */

namespace app\commands;


use app\models\Cities;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\FileHelper;

class CitiesController extends Controller
{

    public function actionUpload($filepath)
    {
        if(is_file($filepath)) {
            $file = json_decode( file_get_contents($filepath), true );
            foreach ($file[0]['regions'] as $value){
                foreach ($value['cities'] as $city){
                    $model = \Yii::createObject(Cities::className());
                    if (! $model->find()->where(['name' => $city['name']])->one()) {
                        $model->name = $city['name'];
                        $model->save();
                    }
                }
            }
        }

        return ExitCode::OK;
    }

    public function actionUploadTranslations($filepath, $translation)
    {
        if(is_file($filepath) && is_file($translation)) {
            $ru = file($filepath);
            $ua = file($translation);

            $counter = 0;
            foreach ($ru as $string) {
                $transl = [
                    'ru' => trim($string),
                    'ua' => trim($ua[$counter]),
                ];

                $model = \Yii::createObject(Cities::className());
//                var_dump($model->find()->where(['like', 'name', '%'.$transl['ru'].'%'])->one());
                if (! $model->find()->where(['like', 'name', $transl['ru']])->all()) {
                    $model->name_ua = $transl['ua'];
                    $model->name = $transl['ru'];

                    $model->save();
                }
                $counter++;
            }
        }
    }
}