<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%likes_types}}`.
 */
class m220908_164210_create_likes_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%likes_types}}', [
            'id' => $this->primaryKey(),
            'icon' => $this->string(255),
            'name' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%likes_types}}');
    }
}
