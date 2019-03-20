<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $params = [];
    
    public $controllerNamespace = 'app\modules\admin\controllers';
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->params['menu'] = [
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => ['/admin/default/index'],
                    'controller' => 'default',
                    'template' => '<a href="#"><i class="icon-compass"></i><span>{label}</span></a>',
                ],
                [
                    'label' => 'Страницы',
                    'url' => ['/admin/pages'],
                    'template' => '<a href="#"><i class="icon-folder"></i><span>{label}</span></a>',
                    'controller' => 'pages',
                    'items' => [
                        [
                            'label' => 'Все страницы',
                            'url' => ['/admin/pages/index'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Главная',
                            'url' => ['/admin/pages/update?id=1'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Как это работает',
                            'url' => ['/admin/pages/update?id=2'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Политика конфиденциальности',
                            'url' => ['/admin/pages/update?id=3'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'Категории',
                    'url' => ['/admin/categories'],
                    'template' => '<a href="#"><i class="icon-folder"></i><span>{label}</span></a>',
                    'controller' => 'categories',
                    'items' => [
                        [
                            'label' => 'Список категорий новостей',
                            'url' => ['/admin/categories/index'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Список категорий объявлений',
                            'url' => ['/admin/categories/advertisements'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать категорию новостей',
                            'url' => ['/admin/categories/create'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать категорию объявлений',
                            'url' => ['/admin/categories/create-adv'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'Новости',
                    'url' => ['/admin/blog'],
                    'template' => '<a href="#"><i class="icon-folder"></i><span>{label}</span></a>',
                    'controller' => 'blog',
                    'items' => [
                        [
                            'label' => 'Список новостей',
                            'url' => ['/admin/blog'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать новость',
                            'url' => ['/admin/blog/create'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'Пользователи',
                    'url' => ['/admin/users'],
                    'controller' => 'user',
                    'template' => '<a href="{url}"><i class="icon-users"></i><span>{label}</span></a>',
                ],
                [
                    'label' => 'Настройки',
                    'url' => ['settings'],
                    'template' => '<a href="#"><i class="icon-wrench"></i><span>{label}</span></a>',
                    'controller' => 'settings',
                    'items' => [
                        [
                            'label' => 'Основные настройки сайта',
                            'url' => ['/admin/settings/main'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Настройки SEO',
                            'url' => ['/admin/settings/seo'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
            ],
            'activeCssClass' => 'open',
            'activateParents' => true,
            'options' => [
                'class' => 'nav'
            ],
            'submenuTemplate' => "\n<ul class='sub-menu' role='menu'>\n{items}\n</ul>\n",
        ];
        // custom initialization code goes here
    }
}
