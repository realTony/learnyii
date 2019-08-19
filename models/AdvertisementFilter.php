<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 20.02.2019
 * Time: 22:12
 */

namespace app\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class AdvertisementFilter extends Model
{
    public $minPrice = 0;
    public $maxPrice = 11000;
    public $minDistance = 0;
    public $maxDistance = 2000;
    public $stickingArea;
    public $extraFilter = [];
    public $subCategory = [];
    public $city;
    public $district;
    public $orderBy;

    public function rules()
    {
        return [
            [['minDistance', 'minPrice', 'maxDistance', 'maxPrice'], 'integer'],
            [['stickingArea', 'extraFilter', 'subCategory'], 'safe'],
            [['city', 'district', 'orderBy'], 'string']
        ];
    }

    public function setProperties( array $properties)
    {
        if(! empty($properties)) {
            foreach ($properties as $index => $property) {
                if(isset($this->$index)) {
                    $this->$index = $property;
                }
            }
        }
        return $this;
    }
}