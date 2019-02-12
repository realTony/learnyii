<?php

namespace app\widgets;

use app\assets\SocialAuthAsset;
use Yii;
use yii\authclient\widgets\AuthChoiceAsset;
use yii\authclient\widgets\AuthChoiceStyleAsset;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;

class SocialAuth extends AuthChoice
{
    public $socImages = [
        'google' => 'images/bg-54.png',
        'facebook' => 'images/bg-53.png'
    ];

    protected function renderMainContent()
    {
        $items = [];
        foreach ($this->getClients() as $externalService) {
            $items[] = $this->clientLink($externalService);
        }
        return Html::tag('div', implode('', $items), ['class' => 'in-network']);
    }

    public function clientLink($client, $text = null, array $htmlOptions = [])
    {
        $viewOptions = $client->getViewOptions();

        if (empty($viewOptions['widget'])) {
            if ($text === null) {
//                $inner = Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]);
                $inner = Html::tag('image', '', ['src' => Url::to(\Yii::getAlias('@web').$this->socImages[$client->getName()]), 'alt' => $client->getName()]);
                $text = Html::tag( 'div', $inner, ['class' => 'holder-img'] );
                $text .= Html::tag('span', \Yii::t('app', 'Войти через '. ucfirst($client->getName())) );
            }

            if (!isset($htmlOptions['title'])) {
                $htmlOptions['title'] = $client->getTitle();
            }
            Html::addCssClass($htmlOptions, ['widget' => 'btn-network']);

            if ($this->popupMode) {
                if (isset($viewOptions['popupWidth'])) {
                    $htmlOptions['data-popup-width'] = $viewOptions['popupWidth'];
                }
                if (isset($viewOptions['popupHeight'])) {
                    $htmlOptions['data-popup-height'] = $viewOptions['popupHeight'];
                }
            }
            return Html::a($text, $this->createClientUrl($client), $htmlOptions);
        }

        $widgetConfig = $viewOptions['widget'];
        if (!isset($widgetConfig['class'])) {
            throw new InvalidConfigException('Widget config "class" parameter is missing');
        }
        /* @var $widgetClass Widget */
        $widgetClass = $widgetConfig['class'];
        if (!(is_subclass_of($widgetClass, AuthChoiceItem::className()))) {
            throw new InvalidConfigException('Item widget class must be subclass of "' . AuthChoiceItem::className() . '"');
        }
        unset($widgetConfig['class']);
        $widgetConfig['client'] = $client;
        $widgetConfig['authChoice'] = $this;
        return $widgetClass::widget($widgetConfig);
    }

    public function init()
    {
        $view = Yii::$app->getView();
        if ($this->popupMode) {
            SocialAuthAsset::register($view);
            if (empty($this->clientOptions)) {
                $options = '';
            } else {
                $options = Json::htmlEncode($this->clientOptions);
            }
            $view->registerJs("jQuery('.in-network').authchoice({$options});");
        } else {
            AuthChoiceStyleAsset::register($view);
        }
        $this->options['id'] = $this->getId();
    }

    public function run()
    {
        $content = '';
//        if ($this->autoRender) {
            $content .= $this->renderMainContent();
//        }
        return $content;
    }
}