<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m251215_005601_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->bigPrimaryKey(),
            'color' => $this->string(20)->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at_unix' => $this->integer()->notNull(),
            'fell_at_unix' => $this->integer()->null(),
            'eaten_percent' => $this->decimal(5, 2)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->null()->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_apple_status', '{{%apple}}', ['status']);
        $this->createIndex('idx_apple_fell_at', '{{%apple}}', ['fell_at_unix']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }
}
