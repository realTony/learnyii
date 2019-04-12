<?php

use yii\db\Migration;

/**
 * Handles adding isTop to table `{{%premium_rates}}`.
 */
class m190412_013100_add_isTop_column_to_premium_rates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%premium_rates}}', 'isUp', $this->boolean()->defaultValue(1));
        $this->addColumn('{{%premium_rates}}', 'isTop', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%premium_rates}}', 'isUp');
        $this->dropColumn('{{%premium_rates}}', 'isTop');
    }
}
