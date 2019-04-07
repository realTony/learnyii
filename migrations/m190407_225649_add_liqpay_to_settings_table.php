<?php

use yii\db\Migration;

/**
 * Class m190407_225649_add_liqpay_to_settings_table
 */
class m190407_225649_add_liqpay_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = [
            [
                'name' => 'liqpay_public_key',
                'option_value' => ''
            ],
            [
                'name' => 'liqpay_private_key',
                'option_value' => ''
            ],
        ];
        $this->batchInsert('{{%settings}}', ['name', 'option_value'], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190407_225649_add_liqpay_to_settings_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190407_225649_add_liqpay_to_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
