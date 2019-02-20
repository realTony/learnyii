<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m190208_230032_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(191),
            'option_value' => $this->text()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $options = [
            [
                'name' => 'site_name',
                'option_value' => 'STICKIT'
            ],
            [
                'name' => 'site_email',
                'option_value' => ''
            ],
            [
                'name' => 'site_telegram',
                'option_value' => ''
            ],
            [
                'name' => 'site_facebook',
                'option_value' => ''
            ],
            [
                'name' => 'site_instagram',
                'option_value' => ''
            ],
            [
                'name' => 'site_viber',
                'option_value' => ''
            ],
            [
                'name' => 'site_maintenance',
                'option_value' => 'Off'
            ],
        ];
        $this->batchInsert('{{%settings}}', ['name', 'option_value'], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
