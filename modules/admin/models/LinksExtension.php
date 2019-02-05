<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 28.01.2019
 * Time: 23:29
 */

namespace app\modules\admin\models;

use app\modules\admin\models\Categories;
use yii\helpers\ArrayHelper;

trait LinksExtension
{
    private $cyr = [
        'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
        'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
        'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
        'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
    ];
    private $lat = [
        'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
        'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
        'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
        'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
    ];

    private function generateLink($title)
    {
        $title.= '.,+-_';
        $title = preg_replace('/[.,=+_-]/', '', $title);
        $title = str_replace(' ', '-', $title);

        return str_replace($this->cyr, $this->lat, mb_strtolower($title) );
    }

    public function getCategories()
    {
        $model = new Categories();

        return ArrayHelper::map($model->find(['is_blog' => 1])->all(), 'id', 'title');
    }
}