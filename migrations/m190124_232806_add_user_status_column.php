<?php

use yii\db\Migration;

/**
 * Class m190124_232806_add_user_status_column
 */
class m190124_232806_add_user_status_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'status', $this
            ->smallInteger(6)
            ->notNull()
            ->defaultValue(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'status');
        echo "m190124_232806_add_user_status_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190124_232806_add_user_status_column cannot be reverted.\n";

        return false;
    }
    */
}
