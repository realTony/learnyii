<?php

use yii\db\Migration;

/**
 * Class m190316_180637_add_views_columt_to_advertisement_post_table
 */
class m190316_180637_add_views_columt_to_advertisement_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%advertisement_post}}', 'filter_id', $this->integer());
        $this->addColumn('{{%advertisement_post}}', 'is_approved', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%advertisement_post}}', 'views', $this->integer()->defaultValue(0));

        $this->createIndex(
            'idx-advertisement_post-filter_id',
            '{{%advertisement_post}}',
            'filter_id');
        $this->addForeignKey(
            'fk-advertisement_post-filter_id',
            '{{%advertisement_post}}',
            'filter_id',
            '{{%advertisement_cat_filters}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%advertisement_post}}', 'is_approved');
        $this->dropColumn('{{%advertisement_post}}', 'views');
    }
}
