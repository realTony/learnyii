<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 08.02.2019
 * Time: 23:56
 */

namespace app\components;


use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /*
     *
     */
    public function execute($user, $item, $params)
    {
       return isset($params['post']) ? $params['post']->author_id == $user : false;
    }

}