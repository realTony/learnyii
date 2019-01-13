<?php

use yii\db\Migration;

/**
 * Handles dropping gravatar_email from table `profile`.
 */
class m190112_112702_drop_gravatar_email_column_from_profile_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%profile}}', 'gravatar_email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profile}}', 'gravatar_email', $this->string(255));
    }
}
