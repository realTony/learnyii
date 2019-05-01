<?php

use yii\db\Migration;

/**
 * Handles adding district_flag to table `{{%city_regions}}`.
 */
class m190429_171547_add_district_flag_column_to_city_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%city_regions}}', 'district_approved_flag', $this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%city_regions}}', 'district_approved_flag');
    }
}
