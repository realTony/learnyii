<?php
namespace app\models;


use yii\base\Model;

class AdvSearch extends Model
{
    public $city;
    public $district;
    public $orderBy;
    public $queried;
    public $catId;
    public $cityId;
    public $extraFilter;

    public function rules()
    {
        return [
            [['city', 'district', 'queried'], 'string'],
            [['cityId', 'cityId'], 'integer']
        ];
    }

    public function search()
    {

    }

}