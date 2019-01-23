<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 15.01.2019
 * Time: 23:50
 */

namespace app\modules\myaccount\models;

use Yii;
use yii\base\Model;
use dektrium\user\models\User;
use dektrium\user\helpers\Password;

class ChangePassword extends Model
{
    public $oldPassword;
    public $newPassword;
    public $repeatNewPassword;

    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'repeatNewPassword'], 'required'],
            [['oldPassword', 'newPassword', 'repeatNewPassword'], 'trim'],
            ['oldPassword',  'string', 'length' => [4, 24]],
            ['newPassword', 'compare', 'compareAttribute' => 'repeatNewPassword'],
            [['oldPassword', 'newPassword', 'repeatNewPassword'], 'default', 'value'  =>  null ],
            // password is validated by validatePassword()
//            ['oldPassword', 'validatePassword'],
//            ['newPassword', 'validatePassword'],
//            ['repeatNewPassword', 'validatePassword']
        ]; // TODO: Change the autogenerated stub
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors); // TODO: Change the autogenerated stub
    }

    public function changePassword()
    {
        if( !$this->validate() ){
            return false;
        }
        $user = Yii::createObject(User::className())->findOne(['id'=>Yii::$app->user->getId()]);
        
        if( ! Password::validate($this->oldPassword, $user->password_hash ))
            return false;

        $user->resetPassword($this->newPassword);

        return true;
    }

    public function attributeLabels()
    {
        return [
            'oldPassword' => Yii::t('app','Старый пароль'),
            'newPassword' => Yii::t('app','Новый пароль'),
            'repeatNewPassword' => Yii::t('app','Повторите новый пароль')
        ];
    }

}