<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertisement_post}}`.
 */
class m190217_164237_create_advertisement_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertisement_post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'subCat_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'pricePerMonth' => $this->float()->notNull(),
            'contract_term' => $this->integer()->notNull(),
            'distancePerMonth' => $this->float()->notNull(),
            'condition' => $this->string(),
            'adv_type' => $this->integer(),
            'sticking_area' => $this->integer(),
            'authorId' => $this->integer()->notNull(),
            'showEmail' => $this->boolean()->notNull()->defaultValue(false),
            'isPremium' => $this->boolean()->notNull()->defaultValue(false),
            'coverage_type' => $this->boolean()->notNull()->defaultValue(false),
            'published_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advertisement_post}}');
    }
}
