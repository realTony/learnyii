<?php

namespace app\models;


use dektrium\user\models\RegistrationForm;
use app\models\User;
use Yii;

/**
 * RegisterForm is the model behind the register form.
 *
 * @property User|null $user This property is read-only.
 *
 */ 

// Can check is User exists
// Can register via Google API
// Can register via Facebook API
// Fields:
	//Username
	//Email
	//Phone
	//City
	//Password
	//Re-enter Password
	//Rules aggriement checkbox

class RegisterForm extends RegistrationForm
{
	public $username;
	public $email;
	public $phone;
	public $city;
	public $password_repeat;
	public $password;
	public $rules_agreement = false;
	public static $usernameRegExp = '/^[a-zA-Zа-яёА-ЯЁ(\ a-zA-Zа-яёА-ЯЁ)?]+$/';

	public function rules()
	{
		return [
            // username rules
            'usernameTrim'     => ['username', 'trim'],
            'usernameRequired' => ['username', 'required', 'on' => ['register', 'create', 'connect', 'update']],
            'usernameMatch'    => ['username', 'match', 'pattern' => self::$usernameRegExp],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
			// username, email, password, re-entred password must be not empty
            [['username', 'email', 'password', 'password_repeat', 'rules_agreement'], 'required'],
            // rememberMe must be a boolean value
            ['rules_agreement', 'required', 'requiredValue' => 1],
            ['rules_agreement', 'boolean'],
            //email must be a valid email address
            ['email','email'],

            // normalize "phone" input
		    ['phone', 'filter', 'filter' => [$this, 'normalizePhone']],
            // password is validated by validateRegForm()
            ['password', 'validateRegForm'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat']
		];
	}

	public function validateRegForm()
	{
		if (!$this->hasErrors()) {
		    return true;
		}
	}


	public function register()
	{
        parent::register();
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);
        if (!$user->register()) {
            return false;
        }else{

        }
	}
	/**
	 * Check if registering user exists at site database
	 * 
	 * @return boolean
	 */
	private function checkUser($email)
	{
		$isExists = false;

		return $isExists;
	}
	/**
	 * Phone normalization method
	 * 
	 * @return phoneNumber|string 
	 */
	public function normalizePhone($value)
	{
		return $value;
	}

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','Имя'),
            'email' => Yii::t('app','E-Mail'),
            'phone' => Yii::t('app','Телефон'),
            'city' => Yii::t('app','Город'),
            'password_repeat' => Yii::t('app','Повторить пароль'),
            'password' => Yii::t('app','Пароль'),
            'rules_agreement' => Yii::t('app','Соглашение с условиями')
        ];
    }
}