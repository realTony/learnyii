<?php

namespace app\models;


use InvalidArgumentException;
use Yii;

class CustomPayment extends \LiqPay
{

    private $data;
    private $publicKey;
    private $privateKey;
    private $_checkout_url = 'https://www.liqpay.ua/api/3/checkout';
    private $language = 'ru';

    public function __construct(string $public_key, string $private_key)
    {
        parent::__construct($public_key, $private_key);

        $this->publicKey = $public_key;
        $this->privateKey = $private_key;
        $this->language = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
    }

    public function setData($data) : void
    {
        $this->data = $data;
    }

    public function getPaymentForm($params) : string
    {
        if (isset($params['language']) && $params['language'] == 'en') {
            $this->language = 'en';
        }

        $params    = $this->cnb_params($this->data);
        $data      = $this->encode_params($params);
        $signature = $this->cnb_signature($params);

        return sprintf('
            <form method="POST" action="%s" accept-charset="utf-8">
                %s
                %s
                <input type="image" src="//static.liqpay.ua/buttons/p1%s.radius.png" name="btn_text" />
            </form>
            ',
            $this->_checkout_url,
            sprintf('<input type="hidden" name="%s" value="%s" />', 'data', $data),
            sprintf('<input type="hidden" name="%s" value="%s" />', 'signature', $signature),
            $this->language
        );
    }

    private function cnb_params($params)
    {
        $params['public_key'] = $this->publicKey;

        if (!isset($params['version'])) {
            throw new InvalidArgumentException('version is null');
        }
        if (!isset($params['amount'])) {
            throw new InvalidArgumentException('amount is null');
        }
        if (!isset($params['currency'])) {
            throw new InvalidArgumentException('currency is null');
        }
        if (!in_array($params['currency'], $this->_supportedCurrencies)) {
            throw new InvalidArgumentException('currency is not supported');
        }
        if ($params['currency'] == self::CURRENCY_RUR) {
            $params['currency'] = self::CURRENCY_RUB;
        }
        if (!isset($params['description'])) {
            throw new InvalidArgumentException('description is null');
        }

        return $params;
    }

    private function encode_params($params)
    {
        return base64_encode(json_encode($params));
    }
}