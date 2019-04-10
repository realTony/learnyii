<?php

use yii\db\Migration;

/**
 * Class m190410_021253_add_order_id_to_user_premium_advertisement_form
 */
class m190410_021253_add_order_id_to_user_premium_advertisement_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_premium_advertisement}}', 'order_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%user_premium_advertisement}}', 'order_id');

        return true;
    }
}
