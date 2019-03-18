<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_premium_advertisement}}`.
 */
class m190316_181558_create_user_premium_advertisement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_premium_advertisement}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'advertisement_id' => $this->integer()->notNull(),
            'premium_type_id' => $this->integer()->notNull(),
            'confirmation_timestamp' => $this->timestamp()->defaultValue(null),
            'expiration_timestamp' => $this->timestamp()->defaultValue(null),
            'is_notification_sent' => $this->boolean()->defaultValue(false),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');


        $this->createIndex(
            'idx-user_premium_advertisement-author_id',
            '{{%user_premium_advertisement}}',
            'author_id');
        $this->createIndex(
            'idx-user_premium_advertisement-advertisement_id',
            '{{%user_premium_advertisement}}',
            'advertisement_id');
        $this->createIndex(
            'idx-user_premium_advertisement-premium_type_id',
            '{{%user_premium_advertisement}}',
            'premium_type_id');

        $this->addForeignKey(
            'fk-user_premium_advertisement-author_id',
            '{{%user_premium_advertisement}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_premium_advertisement-advertisement_id',
            '{{%user_premium_advertisement}}',
            'advertisement_id',
            '{{%advertisement_post}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_premium_advertisement-premium_type_id',
            '{{%user_premium_advertisement}}',
            'premium_type_id',
            '{{%premium_rates}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_premium_advertisement}}');
    }
}
