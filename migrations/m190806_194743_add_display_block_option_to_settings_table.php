<?php

use yii\db\Migration;

/**
 * Class m190806_194743_add_display_block_option_to_settings_table
 */
class m190806_194743_add_display_block_option_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = [
            [
                'name' => 'show_how_it_works',
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
        echo "m190806_194743_add_display_block_option_to_settings_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190806_194743_add_display_block_option_to_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
