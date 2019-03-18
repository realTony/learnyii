<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_fav}}`.
 */
class m190224_215313_create_user_fav_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_fav}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'advertisement_id' => $this->integer()->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_fav}}');
    }
}
