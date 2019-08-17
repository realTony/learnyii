<?php


namespace app\components;


use Yii;

trait L10nTrait
{
    private $currentLanguage = 'uk';

    public function setLanguage()
    {
        $language = Yii::$app->language;
        $this->currentLanguage = ($language == 'ru-Ru') ? 'ru' : $this->currentLanguage;

        return $this;
    }

    public function getLanguage()
    {
        $this->setLanguage();

        return $this->currentLanguage;
    }
}