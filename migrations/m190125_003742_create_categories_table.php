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
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'seo_text' =>$this->text(),
            'seo_title' => $this->string(),
            'link' => $this->string()->notNull()->unique()->defaultValue(''),
            'parent_id' => $this->integer(11)->defaultValue(0),
            'is_blog' => $this->boolean(),
            'options' => $this->text(),
            'translation' => $this->text(),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
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
