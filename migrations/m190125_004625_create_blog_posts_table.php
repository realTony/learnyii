<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog_posts`.
 */
class m190125_004625_create_blog_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_posts}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'link' => $this->string()->notNull()->unique(),
            'category_id' => $this->integer(),
            'post_thumbnail' => $this->string()->notNull()->defaultValue(''),
            'post_image' => $this->string()->notNull()->defaultValue(''),
            'author_id' => $this->integer()->notNull(),
            'seo_title' => $this->string(),
            'seo_text' => $this->text(),
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
        $this->dropTable('{{%blog_posts}}');
    }
}
