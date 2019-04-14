+<?php

return [
    'site/*',
    'premium-demon/*',
//    'myaccount/*',
    'rbac/*',
    'user/*',
//    'admin/*',
    'admin/moderation*',
//    'admin/pages*',
            'gii/*',
            'debug/*',
//            'categories/*',
    'images/*',
    'account/*',
    'search/*',
    'account#login',
    'account#register',
    'news/*',
    'advertisement/*',
//            'some-controller/some-action',
    // The actions listed here will be allowed to everyone including guests.
    // So, 'admin/*' should not appear here in the production, of course.
    // But in the earlier stages of your development, you may probably want to
    // add a lot of actions here until you finally completed setting up rbac,
    // otherwise you may not even take a first step.
];