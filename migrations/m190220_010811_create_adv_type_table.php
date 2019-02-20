<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%adv_type}}`.
 */
class m190220_010811_create_adv_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%adv_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'translation' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $options = [
            [
                'name' => 'Транспорт',
                'translation' => 'Транспорт'
            ],
            [
                'name' => 'Реклама',
                'translation' => 'Реклама'
            ],
            [
                'name' => 'Исполнители',
                'translation' => 'Виконавці'
            ],
        ];
        $this->batchInsert('{{%adv_type}}', ['name', 'translation'], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%adv_type}}');
    }
}
