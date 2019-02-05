<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m190204_012122_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'image_name' => $this->string()->notNull(),
            'module' => $this->string()->notNull(),
            'item_id' => $this->integer(), //id of page
            'alt' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
