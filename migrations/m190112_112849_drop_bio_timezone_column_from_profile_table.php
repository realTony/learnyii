<?php

use yii\db\Migration;

/**
 * Handles dropping bio_timezone from table `profile`.
 */
class m190112_112849_drop_bio_timezone_column_from_profile_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%profile}}', 'bio');
        $this->dropColumn('{{%profile}}', 'timezone');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profile}}', 'bio', $this->text());
        $this->addColumn('{{%profile}}', 'timezone', $this->char(40));
    }
}
