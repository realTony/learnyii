<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%is_banned_column_to_advertisement_post}}`.
 */
class m190326_235313_add_is_banned_column_to_advertisement_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%advertisement_post}}', 'is_banned', $this->boolean()->defaultValue(false));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%advertisement_post}}','is_banned' );

        return true;
    }
}
