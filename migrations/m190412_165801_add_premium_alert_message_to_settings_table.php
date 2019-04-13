<?php

use yii\db\Migration;

/**
 * Class m190412_165801_add_premium_alert_message_to_settings_table
 */
class m190412_165801_add_premium_alert_message_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = [
            [
                'name' => 'premium_alert_message',
                'option_value' => ''
            ]
        ];
        $this->batchInsert('{{%settings}}', ['name', 'option_value'], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190412_165801_add_premium_alert_message_to_settings_table cannot be reverted.\n";

        return false;
    }
}
