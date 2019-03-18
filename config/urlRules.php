<?php

return [
	'' => 'site/index',
	'<action:(account|logout|how-it-works|privacy-policy)>' => 'site/<action>',
	'myaccount' => 'myaccount/default/index',
	'myaccount/edit' => 'myaccount/default/edit',
	'myaccount/create' => 'myaccount/default/create-advertisement',
	'myaccount/update/<id>' => 'myaccount/default/update-advertisement',
	'myaccount/delete/<id>' => 'myaccount/default/delete',
	'myaccount/posts' => 'myaccount/default/posts',
    'user/recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/recovery/reset',
    'admin/blog' => 'admin/blog/index',
    'admin/pages' => 'admin/pages/index',
    'admin/categories' => 'admin/categories/index',
    'admin/users' => 'admin/user/index',
    'admin/settings' => 'admin/settings/index',
    'admin/pages/edit/<link:[A-Za-z0-9_-]+>' => 'admin/pages/update-static',
    'admin/<action>' => 'admin/admin/<action>',
    'admin' => 'admin/default/index',
    'categories/<link:[A-Za-z0-9_-]+>' => 'categories/index',
//    'uk/categories/<link:[A-Za-z0-9_-]+>' => 'categories/index',
    'advertisement' => 'advertisement/index',
    'advertisement/user/<id>' => 'advertisement/user',
//    'advertisement/update/<id>' => 'advertisement/update-advertisement',
    ['pattern' => 'advertisement/<name:[a-z0-9_-]+>/', 'route' => 'advertisement/category', 'suffix' => '/'],
    ['pattern' => 'advertisement/<link>/<sub>', 'route' => 'advertisement/sub-category', 'suffix' => '/'],
    'advertisement/<name:[a-z0-9_-]+>' => 'advertisement/category',
    'advertisement/page/<id>' => 'advertisement/advertise',
    'advertisement/<link>/<sub>' => 'advertisement/sub-category',
    'news/category/<link>' => 'news/category',
    'news/<link>' => 'news/post',
    'news' => 'news/index',
    'search' => 'search/index',
    '<link:[A-Za-z0-9_-]+>' => 'site/page',

];