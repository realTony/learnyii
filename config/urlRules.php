<?php

return [
	'' => 'site/index',
	'<action:(login|logout|account|about)>' => 'site/<action>',
	'myaccount/edit' => 'myaccount/default/edit',
    'user/recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/recovery/reset',
    'admin/<action>' => 'admin/admin/<action>'

];