<?php
namespace app\modules\admin\models;


use app\models\Settings;
use Yii;
use yii\base\Model;

class SaveDynamicSettings extends Model
{
    public $settings = [];


    public function load($data, $formName = null) : bool
    {
        $this->settings = $data;

        return true;
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        if(! empty( $this->settings)) {
            return true;
        }

        return false;
    }

    public function saveSettings() : bool
    {

       if(! $this->validate()) {
           return false;
       }

        foreach ($this->settings as $option => $value) {
            $settingsModel = (Yii::createObject(Settings::className()))
            ->find()
            ->where(['name'=> $option])
            ->one();
            $settingsModel->option_value = json_encode($value);
            $settingsModel->save();
        }

        return true;
    }
}