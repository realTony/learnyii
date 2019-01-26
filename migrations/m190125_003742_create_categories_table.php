<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m190125_003742_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'seo_text' =>$this->text(),
            'seo_title' => $this->string()->defaultValue(''),
            'link' => $this->string(255)->notNull(),
            'parent_id' => $this->smallInteger(6),
            'is_blog' => $this->boolean(),
            'is_advertisement' => $this->boolean(),
            'options' => $this->text(),
            'modified_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
