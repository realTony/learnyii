<?php


namespace app\controllers;


use app\models\Pages;
use Yii;
use yii\web\Controller;

class SiteMapController extends Controller
{

    public function actionSitemap()
    {
        set_time_limit(0);
        $path = realpath(Yii::getAlias('@web'));
        $staticPages = [
            'main',
            'how-it-works',
            'privacy-policy',
            'account',
        ];

        $pages = (new Pages())
            ->find()
            ->where(['not',['in', 'link', $staticPages]])
            ->all();

        $urlSet = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
        $urlSet->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $url = $urlSet->addChild('url');
        $url->addChild('loc', Yii::$app->request->hostInfo);
        $url = $urlSet->addChild('url');
        $url->addChild('loc', Yii::$app->request->hostInfo.'/ru');

        foreach ($staticPages as $page) {
            if($page == 'main') continue;

            $url = $urlSet->addChild('url');
            $url->addChild('loc', Yii::$app->request->hostInfo.'/'.$page);
            $url = $urlSet->addChild('url');
            $url->addChild('loc', Yii::$app->request->hostInfo.'/ru/'.$page);
        }

        $urlSet->saveXML($path . DIRECTORY_SEPARATOR . 'sitemap.xml');

    }
}