<?php


namespace app\components;


use app\models\Settings;
use Yii;
use yii\base\Model;

class SendNotification extends Model
{
    public static function sendNotification($email, $messageTxt)
    {
        $message = Yii::$app->mailer->compose();

        $message->setTo(Yii::$app->params['adminEmail'])
                ->setSubject(Yii::t('app', Yii::$app->name))
                ->setTextBody($messageTxt)
                ->send();
    }

}