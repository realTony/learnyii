<?php

namespace app\models;

use Yii;
use yii\base\Model;

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

class RegisterForm extends Model
{
	public $username;
	public $email;
	public $phone;
	public $city;
	public $password_repeat;
	public $password;
	public $rules_agreement = false;

	public function rules()
	{
		return [
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

		}
	}

	public function register()
	{
		if($this->validate())
		{
			
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
	private function normalizePhone($value)
	{
		return $value;
	}
}