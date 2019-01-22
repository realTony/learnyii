<?php


namespace app\models;


use yii\base\Model;
use Yii;

class RecoveryForm extends Model
{
    public $email;

    private $_user = false;

    public function rules()
    {
        return [
            'emailTrim' => ['email', 'trim'],
            [['email'], 'required'],
            [['email'], 'email'],
        ];
    }

    /**
     * Setting labels for input fields
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
          'email' => Yii::t('app', 'Введите ваш E-Mail')
        ];
    }

    /**
     * Finds user by [[email]] to check if this user is exists
     *
     * @return User|array|bool|\yii\db\ActiveRecord|null
     */
    public function getUser()
    {
        if( $this->_user === false ){
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function restore()
    {
        if( $this->validate() && $this->getUser() ){
            echo "<pre>";
            print_r('test');
            echo "</pre>";die;
        }
    }

    public function sendRecoveryMessage()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();

        if($user instanceof User) {

        }
    }
}