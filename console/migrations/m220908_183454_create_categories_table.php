<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m220908_183454_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'slug' => $this->string(255)->notNull()->unique()->defaultValue(''),
            'image' => $this->string(255),
            'sort' => $this->integer()->defaultValue(0),
            'enabled' => $this->integer(1)->defaultValue(1),
            'parent' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
