<?php


namespace app\components;


use app\models\UserFav;

class SiteComponents
{
    public static function checkUserFav($advertisement) : bool
    {
        if(! \Yii::$app->user->isGuest) {
            $user = \Yii::$app->user->id;

            return (new UserFav())->find()
                    ->where(['user_id' => $user])
                    ->andWhere(['advertisement_id' => $advertisement])->one() != null;
        } else {
            return false;
        }
    }

}