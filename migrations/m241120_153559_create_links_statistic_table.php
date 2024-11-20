<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links_statistic}}`.
 */
class m241120_153559_create_links_statistic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link_stats', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'count' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key constraint
        $this->addForeignKey(
            'fk-link_stats-link_id',
            'link_stats',
            'link_id',
            'links',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-link_stats-link_id', 'link_stats');
        $this->dropTable('link_stats');
    }
}
