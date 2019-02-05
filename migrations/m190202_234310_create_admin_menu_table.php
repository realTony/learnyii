<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin_menu`.
 */
class m190202_234310_create_admin_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable("{{%admin_menu}}", [
            'id' => $this->primaryKey(),
            'label' => $this->string(128)->notNull(),
            'parent' => $this->integer(),
            'route' => $this->string(),
            'order' => $this->integer(),
            'data' => $this->binary(),
        ], $tableOptions);

        $menu = [
                   [
                            'label' => 'Dashboard',
                            'route' => 'admin',
                            'parent' => 0,
                   ], [
                            'label' => 'Страницы',
                            'route' => 'admin/pages',
                            'parent' => 0,
                    ], [
                            'label' => 'Главная',
                            'route' => 'admin/pages',
                            'parent' => 2,
                    ], [
                            'label' => 'Как это работает',
                            'route' => 'admin/pages',
                            'parent' => 2,
                    ], [
                            'label' => 'Политика конфиденциальности',
                            'route' => 'admin/pages',
                            'parent' => 2,

                    ], [
                            'label' => 'Категории',
                            'route' => 'admin/categories',
                            'parent' => 0,
                    ], [
                            'label' => 'Список категорий',
                            'route' => 'admin/categories',
                            'parent' => 3,
                    ], [
                            'label' => 'Создать категорию',
                            'route' => 'admin/categories/create',
                            'parent' => 3,
                    ], [
                            'label' => 'Новости',
                            'route' => 'admin/blog',
                            'parent' => 0,
                    ], [
                            'label' => 'Список новостей',
                            'route' => 'admin/blog',
                            'parent' => 4,
                    ], [
                            'label' => 'Создать категорию',
                            'route' => 'admin/blog/create',
                            'parent' => 4,
                    ]
        ];

        $this->batchInsert('{{%admin_menu}}',['label', 'route', 'parent'], $menu);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%admin_menu}}');
    }
}


