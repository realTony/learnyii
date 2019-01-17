<?php

use yii\db\Migration;

/**
 * Class m190116_174353_add_profile_image_column_from_profile_table
 */
class m190116_174353_add_profile_image_column_from_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'profile_image', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'profile_image');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190116_174353_add_profile_image_column_from_profile_table cannot be reverted.\n";

        return false;
    }
    */
}
