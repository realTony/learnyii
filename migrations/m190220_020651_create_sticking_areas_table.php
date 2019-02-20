<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sticking_areas}}`.
 */
class m190220_020651_create_sticking_areas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sticking_areas}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'translation' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $options = [
            [
                'title' => 'Полная обклейка',
                'translation' => 'Повна обклейка'
            ],
            [
                'title' => 'Частичная обклейка',
                'translation' => 'Часткова обклейка'
            ],
            [
                'title' => 'Навесная реклама',
                'translation' => 'Навісна реклама'
            ],
            [
                'title' => 'Реклама в салоне',
                'translation' => 'Реклама в салоні'
            ],
        ];
        $this->batchInsert('{{%sticking_areas}}', ['title', 'translation'], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sticking_areas}}');
    }
}
