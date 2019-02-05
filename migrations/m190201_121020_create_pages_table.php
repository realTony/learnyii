<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pages`.
 */
class m190201_121020_create_pages_table extends Migration
{
    private $tableName = '{{%pages}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'link' => $this->string()->unique(),
            'seo_title' => $this->string(),
            'seo_text' => $this->text(),
            'options' => $this->text(),
            'translation' => $this->text(),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->insert($this->tableName, [
            'title' => 'Главная',
            'link' => 'main',
        ]);
        $this->insert($this->tableName, [
            'title' => 'Как это работает?',
            'link' => 'how-it-works',
        ]);
        $this->insert($this->tableName, [
            'title' => 'Политика конфиденциальности',
            'link' => 'privacy-policy',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->tableName, ['id' => [1,2,3]]);
        $this->dropTable($this->tableName);
    }
}
