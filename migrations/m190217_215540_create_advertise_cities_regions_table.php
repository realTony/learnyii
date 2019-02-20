<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertise_cities_regions}}`.
 */
class m190217_215540_create_advertise_cities_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertise_cities_regions}}', [
            'id' => $this->primaryKey(),
            'advertise_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'region_id' => $this->integer()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advertise_cities_regions}}');
    }
}
