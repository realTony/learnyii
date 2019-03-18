<?php

use yii\db\Migration;

/**
 * Class m190315_121041_create_advertisement_item_type
 */
class m190315_121041_create_advertisement_cat_filters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertisement_cat_filters}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'filter_name' => $this->string()->notNull(),
            'filter_translation' => $this->string()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex(
        'idx-advertisement_cat_filters-category_id',
        '{{%advertisement_cat_filters}}',
        'category_id');
        $this->createIndex(
            'idx-advertisement_cat_filters-type_id',
            '{{%advertisement_cat_filters}}',
            'type_id');

        $this->addForeignKey(
            'fk-advertisement_cat_filters-category_id',
            '{{%advertisement_cat_filters}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-advertisement_cat_filters-type_id',
            '{{%advertisement_cat_filters}}',
            'type_id',
            '{{%adv_type}}',
            'id',
            'CASCADE'
        );

        $insertPack = [
            [
                'category_id' => 8,
                'type_id' => 1,
                'filter_name' => 'Полная оклейка',
                'filter_translation' => 'Повне обклеювання',
            ], [
                'category_id' => 8,
                'type_id' => 1,
                'filter_name' => 'Частичная оклейка',
                'filter_translation' => 'Часткове обклеювання',
            ], [
                'category_id' => 8,
                'type_id' => 1,
                'filter_name' => 'Навесная реклама',
                'filter_translation' => 'Навісна реклама',
            ], [
                'category_id' => 8,
                'type_id' => 1,
                'filter_name' => 'Реклама в салоне',
                'filter_translation' => 'Реклама в салоні',
            ], [
                'category_id' => 9,
                'type_id' => 2,
                'filter_name' => 'Легковые автомобили',
                'filter_translation' => 'Легкові автомобілі',
            ], [
                'category_id' => 9,
                'type_id' => 2,
                'filter_name' => 'Мото',
                'filter_translation' => 'Мото',
            ], [
                'category_id' => 9,
                'type_id' => 2,
                'filter_name' => 'Прицепы',
                'filter_translation' => 'Причепи',
            ], [
                'category_id' => 9,
                'type_id' => 2,
                'filter_name' => 'Грузовики',
                'filter_translation' => 'Вантажівки',
            ], [
                'category_id' => 9,
                'type_id' => 2,
                'filter_name' => 'Автобусы',
                'filter_translation' => 'Автобуси',
            ], [
                'category_id' => 9,
                'type_id' => 2,
                'filter_name' => 'Велосипеды',
                'filter_translation' => 'Велосипеди',
            ], [
                'category_id' => 9,
                'type_id' => 2,
                'filter_name' => 'Другое',
                'filter_translation' => 'Інше',
            ]
        ];

        $this->batchInsert('{{%advertisement_cat_filters}}', ['category_id', 'type_id', 'filter_name', 'filter_translation'], $insertPack);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advertisement_cat_filters}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190315_121041_create_advertisement_item_type cannot be reverted.\n";

        return false;
    }
    */
}
