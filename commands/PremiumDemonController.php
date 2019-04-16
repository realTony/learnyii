<?php

namespace app\commands;


use app\models\AdvertisementPost;
use app\models\PremiumRates;
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
        $currentDate = (new \DateTime())->format('Y-m-d H:i:s');
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
        $startTime = microtime(true);
        $endTime = false;
        $userPurchases = new UserPremiumAdvertisement();
        $settings = new Settings();
        $currentDate = (new \DateTime());
        $expiredPosts  = $userPurchases
            ->find()
            ->where(['not', ['confirmation_timestamp' => null, 'expiration_timestamp' => null]])
            ->andWhere(['is_notification_sent' => 0])
            ->andWhere(['<', 'confirmation_timestamp', $currentDate->format('Y-m-d H:i:s')])
            ->andWhere(['>', 'expiration_timestamp', $currentDate->format('Y-m-d H:i:s')] )
            ->all();

        foreach ($expiredPosts as $userPost) {
            $rate = ( new PremiumRates())
                ->findOne(['id' => $userPost->premium_type_id]);
            $compareDate = ($rate->duration > 24) ?
                    (new \DateTime($userPost->expiration_timestamp))->modify('-24 hours') : (new \DateTime($userPost->expiration_timestamp))->modify('-12 hours');

            if( $compareDate <= $currentDate) {

                 $userEmail = Yii::$app->db
                     ->createCommand('SELECT `email` FROM {{%user}} WHERE id=:id')
                     ->bindValue(':id', $userPost->author_id)
                 ->queryOne();
                 $status = Yii::$app->mailer->compose()
                     ->setFrom($settings->siteEmail->option_value)
                     ->setTo($userEmail['email'])
                     ->setSubject('Уведомление')
                     ->setHtmlBody($settings->emailNotification->option_value)
                     ->send();

                 Yii::$app->db->createCommand('UPDATE {{%user_premium_advertisement}} SET `is_notification_sent` = 1 WHERE `id`=:id')
                 ->bindValue(':id',$userPost->id)
                 ->query();
            }

        }

        $endTime = microtime(true);
    }
}