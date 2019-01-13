<?php

use yii\db\Migration;

/**
 * Handles adding profile to table `profile`.
 */
class m190112_113956_add_profile_columns_to_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'last_name', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'phone', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'viber', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'telegram', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'whatsapp', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'last_name');
        $this->dropColumn('{{%profile}}', 'phone');
        $this->dropColumn('{{%profile}}', 'viber');
        $this->dropColumn('{{%profile}}', 'telegram');
        $this->dropColumn('{{%profile}}', 'whatsapp');
    }
}
