<?php

namespace app\modules\admin\models;


use app\models\AuthAssignment;
use yii\base\Model;
use dektrium\user\models\User;
use Yii;

class EditUser extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $profileType;
    public static $usernameRegExp = '/^[a-zA-Zа-яёА-ЯЁ(\ a-zA-Zа-яёА-ЯЁ)?]+$/';

    public function rules() : array
    {
        return [
            'usernameTrim'     => ['username', 'trim'],
//            'usernameRequired' => ['username', 'required', 'on' => ['register', 'create', 'connect', 'update']],
////            'usernameMatch'    => ['username', 'match', 'pattern' => self::$usernameRegExp],
//            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            ['email','email'],
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'username' => Yii::t('app',Yii::t('app', 'Имя')),
            'email' => Yii::t('app', Yii::t('app', 'E-mail')),
            'password' => Yii::t('app', Yii::t('app','Пароль')),
        ];
    }

    public function load($data, $formName = null)
    {
        foreach ($data['EditUser'] as $name => $value) {
            $this->$name = $value;
        }

        return true;
    }

    public function edit()
    {
        if(! $this->validate()) {
            return false;
        }

        $user = User::findOne(['id' => $this->id] );

        $user->resetPassword($this->password);

        $assignment = new AuthAssignment();

        $user->email = $this->email;
        $user->username = $this->username;
        if(! $user->save()) {
            return false;
        }

        if($assignment->find()->where(['user_id' => $this->id])->one()) {
            $rule = $assignment->find()->where(['user_id' => $this->id])->one();
            $rule->item_name = $this->profileType;
            if(! $rule->save()) {
                return false;
            }

        } else {
            $assignment->item_name = $this->profileType;
            $assignment->user_id = $this->id;

            if( $user->save() && $assignment->save() ) {
                return true;
            } else {

                return false;
            }
        }

        return true;
    }
}