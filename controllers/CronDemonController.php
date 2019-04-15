<?php

namespace app\controllers;


use app\commands\PremiumDemonController;
use app\models\Settings;
use app\models\UserPremiumAdvertisement;
use Yii;
use yii\web\Controller;

class CronDemonController extends Controller
{
    public function beforeAction($action)
    {
        if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR'])
        {
            var_dump($_SERVER['REMOTE_ADDR']);
            var_dump($_SERVER['SERVER_ADDR']);
            return true;
        }
        return false; // or false to not run the action
    }

    public function actionSentNotifications()
    {
        $startTime = microtime(true);
        $endTime = false;
        $userPurchases = new UserPremiumAdvertisement();
        $currentDate = date('Y-m-d H:i:s', time());
        $expiredPosts  = $userPurchases
            ->find()
            ->where(['not', ['confirmation_timestamp' => null, 'expiration_timestamp' => null]])
            ->andWhere(['is_notification_sent' => 0])
            ->andWhere(['<', 'confirmation_timestamp', $currentDate])
            ->andWhere(['>', 'expiration_timestamp', $currentDate] )
            ->all();

        foreach ($expiredPosts as $userPost) {
            $userEmail = Yii::$app->db
                ->createCommand('SELECT `email` FROM {{%user}} WHERE id=:id')
                ->bindValue(':id', $userPost->author_id)
                ->queryOne();

            $settings = new Settings();

            Yii::$app->mailer->compose()
                ->setFrom($settings->siteEmail->option_value)
                ->setTo($userEmail['email'])
                ->setSubject('Уведомление')
                ->setHtmlBody($settings->emailNotification->option_value)
                ->send();

            $res = Yii::$app->db
                ->createCommand('UPDATE {{%user_premium_advertisement}} SET `is_notification_sent` = 1
                    WHERE `id`=:id')
                ->bindValue(':id',$userPost->id)
                ->query();

        }
        $endTime = microtime(true);

        echo 'Processing for '.($endTime - $startTime).' seconds';

    }

}