<?php

use \yii\widgets\Menu;
use \mdm\admin\components\Helper;

$menu = $this->params['menu'];

foreach ($menu['items'] as $key => $item) {

    if (! Helper::checkRoute($item['url'][0])) {
        unset($menu['items'][$key]);
    }

    if (! empty($item['controller']) && $item['controller'] == \Yii::$app->controller->id) {
        $menu['items'][$key]['active'] = true;
    }
}

?>
<!-- main navigation -->
<nav role="navigation">
    <?= Menu::widget($menu) ?>
</nav>
<!-- /main navigation -->