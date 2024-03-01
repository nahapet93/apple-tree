<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m240228_170718_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apples}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(),
            'created_at' => $this->timestamp()->defaultValue(null),
            'fell_at' => $this->timestamp()->defaultValue(null),
            'status' => $this->tinyInteger()->unsigned(),
            'percent_eaten' => $this->float()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apples}}');
    }
}
