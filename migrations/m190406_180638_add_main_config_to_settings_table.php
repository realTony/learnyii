<?php

use yii\db\Migration;

/**
 * Class m190406_180638_add_main_config_to_settings_table
 */
class m190406_180638_add_main_config_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = [
            [
                'name' => 'main_slider_max',
                'option_value' => 5
            ],
            [
                'name' => 'advertisement_pageSize',
                'option_value' => 29
            ],
            [
                'name' => 'vip_message_ru',
                'option_value' => ''
            ],
            [
                'name' => 'vip_message_uk',
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
        echo "m190406_180638_add_main_config_to_settings_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190406_180638_add_main_config_to_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
