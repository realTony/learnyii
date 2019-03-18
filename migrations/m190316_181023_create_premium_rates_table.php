<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%premium_rates}}`.
 */
class m190316_181023_create_premium_rates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%premium_rates}}', [
            'id' => $this->primaryKey(),
            'rate' => $this->string(),
            'rate_ua' => $this->string(),
            'price' => $this->double(12),
            'duration' => $this->integer()->defaultValue(24) //Hours
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%premium_rates}}');
    }
}
