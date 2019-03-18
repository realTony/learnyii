<?php

use yii\db\Migration;

/**
 * Class m190301_003149_add_is_archived_column_to_advertisement_post
 */
class m190301_003149_add_is_archived_column_to_advertisement_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%advertisement_post}}', 'is_archived', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%advertisement_post}}', 'is_archived');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190301_003149_add_is_archived_column_to_advertisement_post cannot be reverted.\n";

        return false;
    }
    */
}
