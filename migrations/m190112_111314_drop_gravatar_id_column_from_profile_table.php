<?php

use yii\db\Migration;

/**
 * Handles dropping gravatar_id from table `profile`.
 */
class m190112_111314_drop_gravatar_id_column_from_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%profile}}', 'gravatar_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profile}}', 'gravatar_id', $this->string(32));
    }
}
