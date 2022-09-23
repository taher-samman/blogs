<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blogs}}`.
 */
class m220921_135322_add_updated_at_column_to_blogs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blogs}}', 'updated_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blogs}}', 'updated_at');
    }
}
