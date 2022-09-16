<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blogs}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%categories}}`
 */
class m220908_163212_create_blogs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blogs}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(255),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->string(255),
            'cat_id' => $this->integer(),
            'enabled' => $this->integer(1)->defaultValue(1),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-blogs-user_id}}',
            '{{%blogs}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-blogs-user_id}}',
            '{{%blogs}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `cat_id`
        $this->createIndex(
            '{{%idx-blogs-cat_id}}',
            '{{%blogs}}',
            'cat_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-blogs-cat_id}}',
            '{{%blogs}}',
            'cat_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-blogs-user_id}}',
            '{{%blogs}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-blogs-user_id}}',
            '{{%blogs}}'
        );

        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-blogs-cat_id}}',
            '{{%blogs}}'
        );

        // drops index for column `cat_id`
        $this->dropIndex(
            '{{%idx-blogs-cat_id}}',
            '{{%blogs}}'
        );

        $this->dropTable('{{%blogs}}');
    }
}
