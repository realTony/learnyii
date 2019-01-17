<?php

use yii\db\Migration;

/**
 * Handles dropping username from table `profile`.
 */
class m190116_165426_drop_username_column_from_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%profile}}', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profile}}', 'name', $this->string(255));
    }
}
