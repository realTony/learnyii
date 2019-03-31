<?php

use yii\db\Migration;

/**
 * Handles adding description to table `{{%premium_rates}}`.
 */
class m190331_001002_add_description_column_to_premium_rates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%premium_rates}}', 'description', $this->text());
        $this->addColumn('{{%premium_rates}}', 'description_ua', $this->text());
        $this->addColumn('{{%premium_rates}}', 'rate_icon', $this->string()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%premium_rates}}', 'description');
        $this->dropColumn('{{%premium_rates}}', 'description_ua');
        $this->dropColumn('{{%premium_rates}}', 'rate_icon');

        return true;
    }
}
