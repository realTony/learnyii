<?php

use yii\helpers\Url;

class LoginCest
{
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/account#login');
        $I->see('Вхід', 'a');

        $I->amGoingTo('try to login with correct credentials');
        $I->click('input[name="LoginForm[email]"]');
        $I->fillField('input[name="LoginForm[email]"]', 'diamantweb.dev3@gmail.com');
        $I->click('input[name="LoginForm[password]"]');
        $I->fillField('input[name="LoginForm[password]"]', 'test123');
        $I->click('.btn-orange');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see user info');
        $I->see('Особистий кабінет');
    }
}
