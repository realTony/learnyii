<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city_regions}}`.
 */
class m190217_215513_create_city_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city_regions}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer()->notNull(),
            'region' => $this->string()->notNull(),
            'region_ua' => $this->string()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city_regions}}');
    }
}
