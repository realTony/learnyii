<?php

namespace app\commands;


use app\models\AdvertisementPost;
use app\models\Settings;
use app\models\UserPremiumAdvertisement;
use Yii;
use yii\console\Controller;

class PremiumDemonController extends Controller
{

    public function actionIndex()
    {
        $posts = new AdvertisementPost();
        $userPurchases = new UserPremiumAdvertisement();
        $currentDate = date('Y-m-d H:i:s', time());
        $expiredPosts  = $userPurchases
            ->find()
            ->where(['not', ['confirmation_timestamp' => null, 'expiration_timestamp' => null]])
            ->andWhere(['>=', 'expiration_timestamp', $currentDate])
            ->andWhere(['is_notification_sent' => 1])
            ->all();

        foreach ($expiredPosts as $post ) {
            $advertisement = $posts->findOne(['id' => $post->advertisement_id]);
            $advertisement->isPremium = 0;

            if($advertisement->save()) {
                $post->delete();
            }
        }

        return true;
    }

    public function actionSendNotifications()
    {
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
                    ->createCommand('UPDATE {{%user_premium_advertisement}} SET `is_notification_sent` = 1')
                    ->query();

        }
    }
}