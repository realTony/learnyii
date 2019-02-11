<?php

namespace app\models;


use dektrium\user\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;

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
	public static $usernameRegExp = '/^[a-zA-z\p{Cyrillic}\D]+$/';

	public function rules()
	{
		return [
            // username rules
            [['username', 'email', 'password', 'password_repeat'], 'trim'],
            ['username', 'match', 'pattern' => self::$usernameRegExp],
			// username, email, password, re-entred password must be not empty
            [['username', 'email', 'password', 'password_repeat', 'rules_agreement'], 'required'],
            // rememberMe must be a boolean value
            ['rules_agreement', 'required', 'requiredValue' => 1, 'message' => Yii::t('app', 'Подтвердите согласие с условиями использования')],
            ['rules_agreement', 'boolean'],
            //Set default value for rules
            ['rules_agreement', 'default', 'value' => 0],
            //email must be a valid email address
            // email rules
            'emailRequired' => ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'emailPattern'  => ['email', 'email'],
            'emailLength'   => ['email', 'string', 'max' => 255],
            'emailUnique'   => [
                'email',
                'unique',
                'message' => \Yii::t('user', 'This email address has already been taken'),
                'targetClass' => '\app\models\User'
            ],
//            ['email','email'],
//            ['email', 'unique','targetAttribute' => 'email', 'targetClass' => 'app\models\User'],

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
        if(!$this->validate()) {
            return false;
        }
        $user = Yii::createObject(User::className());
        $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', User::STATUS_ACTIVE);
        $user->setScenario('register');
        $this->loadAttributes($user);

        if(!$user->register()) {
            return false;
        }

        Yii::$app->session->setFlash(
            'info',
            Yii::t(
                'user',
                'Your account has been created and a message with further instructions has been sent to your email'
            )
        );

        return true;
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