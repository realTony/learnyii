<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\UrlManager;

class LanguageSwitcher extends Widget
{
    private static $_labels;

    public $items = [];
    public $options = [];

    private $_isError;

    public function init()
    {
        $route = Yii::$app->controller->route;
        $appLanguage = Yii::$app->language;
        $params = $_GET;
        $this->_isError = $route === Yii::$app->errorHandler->errorAction;

        array_unshift($params, '/' . $route);

        foreach (Yii::$app->urlManager->languages as $language) {
            $isWildcard = substr($language, -2) === '-*';

            if ($isWildcard) {
                $language = substr($language, 0, 2);
            }

            $params['active'] = false;

            if ( Yii::$app->language == $language) {
                $params['active'] = true;
            }

            $params['language'] = $language;

            $this->items[] = [
                'label' => self::label($language),
                'url' => $params,
            ];
        }
        parent::init();
    }

    public function run()
    {
        $class = (! empty($this->options['class'])) ? $this->options['class'] :'';
        $langList = "<ul class=\"$class\">";
        // Only show this widget if we're not on the error page
        if ($this->_isError) {
            return '';
        } else {
            foreach ($this->items as $lang) {
                $activeClass = '';
                if($lang['url']['active']) {
                    $activeClass = 'active';
                }
                $langList .= "<li class=\"$activeClass\">";

                $langList .= Html::a($lang['label'], Url::to([\Yii::$app->controller->action->id, 'language' => $lang['url']['language']]));
                $langList .= '</li>/n';
            }
        }
        $langList .= '</ul>';

        echo $langList;
    }

    public static function label($code)
    {
        if (self::$_labels === null) {
            self::$_labels = [
                'ru-Ru' => Yii::t('app', 'РУС'),
                'uk-Uk' => Yii::t('app', 'УКР'),
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }
}