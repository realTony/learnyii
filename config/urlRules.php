<?php

return [
	'' => 'site/index',
	'<action:(account|logout|how-it-works|privacy-policy)>' => 'site/<action>',
	'myaccount/edit' => 'myaccount/default/edit',
    'user/recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/recovery/reset',
    'admin/blog' => 'admin/blog/index',
    'admin/pages' => 'admin/pages/index',
    'admin/categories' => 'admin/categories/index',
    'admin/pages/edit/<link:[A-Za-z0-9_-]+>' => 'admin/pages/update-static',
    'admin/<action>' => 'admin/admin/<action>',
    'categories/<link:[A-Za-z0-9_-]+>' => 'categories/index',
    'uk/categories/<link:[A-Za-z0-9_-]+>' => 'categories/index',
    'advertisement/<name>' => 'advertisement/category',
    'advertisement/<link>/<sub>' => 'advertisement/sub-category',
    'news/category/<link>' => 'news/category',
    'uk/news/category/<link>' => 'news/category',
    'news/<link>' => 'news/post',
    'uk/news/<link>' => 'news/post'

];