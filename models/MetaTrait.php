<?php

namespace app\models;


use app\components\L10nTrait;
use Yii;

trait MetaTrait
{
    /** @var object $model - object of current page*/
    private  $model;
    /** @var array $metaData - empty template of metaData to set
     * it if model has uncommon structure
     */
    private $metaData = [
        'title' => '',
        'seo_title' => '',
        'seo_description' => '',
        'seo_text' => '',
        'no_index' => 0,
        'no_follow' => 0,
    ];

    public function setMetaData($model)
    {
        $this->setModel($model)
             ->setTitle()
             ->setDescription()
             ->setSeoTitle()
             ->setSeoText()
             ->setNoIndex()
             ->setNoFollow();


        $noIndex = '';

        if($this->metaData['no_index'] == 1) {
            $noIndex = 'noindex';
        }

        if($this->metaData['no_follow'] == 1) {
            $noIndex .= ', nofollow';
        }

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => $noIndex
        ]);
        Yii::$app->view->title = (empty($this->metaData['seo_title'])) ?
            $this->metaData['title'] : $this->metaData['seo_title'];
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->metaData['seo_description']
        ]);

    }

    public function getMetaData() : array
    {
        return $this->metaData;
    }


    private function setModel(object $model) : object
    {
        $this->model = $model;
        if(Yii::$app->language == 'uk') {
            $this->model->options = $this->model->translation;
        }

        return $this;
    }

    private function setTitle() : object
    {
        $this->metaData['title'] = $this->getOption('title');

        return $this;
    }

    private function setSeoTitle() : object
    {
        $this->metaData['seo_title'] =
            $this->getOption('seo_title');

        return $this;
    }

    private function setDescription() : object
    {
        $this->metaData['seo_description'] =
            $this->getOption('seo_description');

        return $this;
    }

    private function setSeoText()
    {
        $this->metaData['seo_text'] = $this->getOption('seo_text');

        return $this;
    }

    private function setNoIndex()
    {
        $this->metaData['no_index'] = $this->getOption('no_index');

        return $this;
    }

    private function setNoFollow()
    {
        $this->metaData['no_follow'] = $this->getOption('no_follow');

        return $this;
    }

    private function getOption($option)
    {
        return (! empty($this->model->options[$option])) ?
            $this->model->options[$option] : $this->metaData[$option];
    }

}