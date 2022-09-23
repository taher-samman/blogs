<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%likes}}`.
 */
class m220921_135349_add_created_at_column_to_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%likes}}', 'created_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%likes}}', 'created_at');
    }
}
