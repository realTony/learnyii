<?php

use yii\db\Migration;

/**
 * Handles the creation of table `messages`.
 */
class m190121_223938_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'user_from' => $this->integer(11),
            'user_to' => $this->integer(11),
            'modified_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
    }
}
