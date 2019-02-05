<?php

use \yii\widgets\Menu;

$menu = $this->params['menu'];

foreach ($menu['items'] as $key => $item) {
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