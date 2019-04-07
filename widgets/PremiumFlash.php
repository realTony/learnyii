<?php

namespace app\widgets;

use yii\helpers\Html;

class PremiumFlash extends \yii\bootstrap\Alert
{
    public $closeButton = [
        'tag' => 'a',
        'label' => '<i class="fas fa-times"></i>'
    ];

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        Html::addCssClass($this->options, ['fade', 'in']);

        if ($this->closeButton !== false) {
            $this->closeButton = array_merge([
                'data-dismiss' => 'alert',
                'data-target' => '.advertise',
                'aria-hidden' => 'true',
                'class' => 'closed-advertise',
            ], $this->closeButton);
        }
    }

    /**
     * Renders the alert body (if any).
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        return "<p><i class=\"fas fa-crown\"></i>{$this->body}</p>\n";
    }
}