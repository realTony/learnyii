<?php

namespace app\models;


use InvalidArgumentException;
use Yii;
use yii\helpers\Url;

class CustomPayment extends \LiqPay
{

    private $data;
    private $publicKey;
    private $privateKey;
    private $_checkout_url = 'https://www.liqpay.ua/api/3/checkout';
    private $language = 'ru';
    public $advertisementId = '';
    public $premiumRateId = '';

    public function __construct(string $public_key, string $private_key)
    {
        parent::__construct($public_key, $private_key);

        $this->publicKey = $public_key;
        $this->privateKey = $private_key;
        $this->language = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

        return $this;
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
            <form method="POST" action="%s" accept-charset="utf-8" data-orderUrl="'.Url::toRoute(['/myaccount/premium-order']).'" data-advertisement="'.$this->advertisementId.'" data-rate="'.$this->premiumRateId.'">
                %s
                %s
                <button style="border: none !important; display:inline-block !important;text-align: center !important;padding: 7px 20px !important;
                    color: #fff !important; font-size:16px !important; font-weight: 600 !important; font-family:OpenSans, sans-serif; cursor: pointer !important; border-radius: 2px !important;
                    background: rgb(122,183,43) !important;"onmouseover="this.style.opacity=\'0.5\';" onmouseout="this.style.opacity=\'1\';">
                    <img src="https://static.liqpay.ua/buttons/logo-small.png" name="btn_text"
                        style="display: inline; margin-right: 7px !important; vertical-align: middle !important;"/>
                    <span style="vertical-align:middle !important;">%s</span>
                </button>
            </form>
            ',
            $this->_checkout_url,
            sprintf('<input type="hidden" name="%s" value="%s" />', 'data', $data),
            sprintf('<input type="hidden" name="%s" value="%s" />', 'signature', $signature),
            Yii::t('app', 'Оплатить')
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