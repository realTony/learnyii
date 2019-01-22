<?php

namespace app\modules\user\controllers;

use dektrium\user\controllers\RegistrationController as MyRegistrationController;

class RegistrationController extends MyRegistrationController
{
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

        $user->attemptConfirmation($code);

        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        return $this->render('message', [
            'title'  => \Yii::t('user', 'Account confirmation'),
            'module' => $this->module,
        ]);
    }
}