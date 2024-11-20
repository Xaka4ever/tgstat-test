<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links}}`.
 */
class m241120_151934_create_links_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'short_token' => $this->string()->notNull(),
            'date_create' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%links}}');
    }
}
