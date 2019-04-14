<?php

namespace app\controllers;


use app\commands\PremiumDemonController;
use yii\web\Controller;

class CronDemonController extends Controller
{
    public function beforeAction($action)
    {
        if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR'])
        {
            return true;
        }
        return false; // or false to not run the action
    }

    public function actionSentNotifications()
    {
        $premiumDemon = new PremiumDemonController();

        return $premiumDemon->actionSendNotifications();
    }

}