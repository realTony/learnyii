<?php

use yii\db\Migration;

/**
 * Class m190321_230010_add_seo_settings_to_settings_table
 */
class m190321_230010_add_seo_settings_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = [
            [
                'name' => 'account_settings',
                'option_value' => ''
            ],
            [
                'name' => 'account_create_settings',
                'option_value' => ''
            ],
            [
                'name' => 'news_settings',
                'option_value' => ''
            ],
            [
                'name' => 'search_settings',
                'option_value' => ''
            ],
            [
                'name' => 'advertisement_settings',
                'option_value' => ''
            ],
            [
                'name' => 'user_advertisement',
                'option_value' => ''
            ],
            [
                'name' => 'inner_advertisement',
                'option_value' => ''
            ]
        ];
        $this->batchInsert('{{%settings}}', ['name', 'option_value'], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() : bool
    {
        echo "m190321_230010_add_seo_settings_to_settings_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190321_230010_add_seo_settings_to_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
