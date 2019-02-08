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
                    'url' => ['admin'],
                    'controller' => 'default',
                    'template' => '<a href="#"><i class="icon-compass"></i><span>{label}</span></a>',
                ],
                [
                    'label' => 'Страницы',
                    'url' => ['admin/pages'],
                    'template' => '<a href="#"><i class="icon-folder"></i><span>{label}</span></a>',
                    'controller' => 'pages',
                    'items' => [
                        [
                            'label' => 'Главная',
                            'url' => ['pages/update?id=1'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Как это работает',
                            'url' => ['pages/update?id=2'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Политика конфиденциальности',
                            'url' => ['pages/update?id=3'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'Категории',
                    'url' => ['categories'],
                    'template' => '<a href="#"><i class="icon-folder"></i><span>{label}</span></a>',
                    'controller' => 'categories',
                    'items' => [
                        [
                            'label' => 'Список категорий',
                            'url' => ['admin/categories'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать категорию новостей',
                            'url' => ['categories/create'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать категорию объявлений',
                            'url' => ['categories/create-adv'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'Новости',
                    'url' => ['admin/blog'],
                    'template' => '<a href="#"><i class="icon-folder"></i><span>{label}</span></a>',
                    'controller' => 'blog',
                    'items' => [
                        [
                            'label' => 'Список новостей',
                            'url' => ['admin/blog'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать новость',
                            'url' => ['blog/create'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'Пользователи',
                    'url' => ['users'],
                    'template' => '<a href="#"><i class="icon-users"></i><span>{label}</span></a>',
                    'controller' => 'users',
                    'items' => [
                        [
                            'label' => 'Список категорий',
                            'url' => ['admin/categories'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать категорию',
                            'url' => ['categories/create'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'Настройки',
                    'url' => ['settings'],
                    'template' => '<a href="#"><i class="icon-wrench"></i><span>{label}</span></a>',
                    'controller' => 'settings',
                    'items' => [
                        [
                            'label' => 'Список категорий',
                            'url' => ['admin/categories'],
                            'template' => '<a href="{url}"><span>{label}</span></a>'
                        ],
                        [
                            'label' => 'Создать категорию',
                            'url' => ['categories/create'],
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
