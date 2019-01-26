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
            'link' => $this->string(),
            'category_id' => $this->integer(),
            'post_thumbnail' => $this->string(),
            'post_image' => $this->string(),
            'author_id' => $this->integer(),
            'seo_title' => $this->string(),
            'seo_text' => $this->text(),
            'created_at' => $this->date(),
            'modified_at' => $this->dateTime()
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
