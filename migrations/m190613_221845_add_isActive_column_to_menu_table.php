<?php

use yii\db\Migration;

/**
 * Handles adding isActive to table `{{%menu}}`.
 */
class m190613_221845_add_isActive_column_to_menu_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%menu}}', 'is_active', $this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%menu}}', 'is_active');
    }
}
