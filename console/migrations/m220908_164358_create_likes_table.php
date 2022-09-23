<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%likes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blogs}}`
 * - `{{%user}}`
 * - `{{%likes_types}}`
 */
class m220908_164358_create_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%likes}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(),
            'user_id' => $this->integer(),
            'type' => $this->integer(),
        ]);

        // creates index for column `blog_id`
        $this->createIndex(
            '{{%idx-likes-blog_id}}',
            '{{%likes}}',
            'blog_id'
        );

        // add foreign key for table `{{%blogs}}`
        $this->addForeignKey(
            '{{%fk-likes-blog_id}}',
            '{{%likes}}',
            'blog_id',
            '{{%blogs}}',
            'id',
            'CASCADE'
        );

        // unique user and blog
        $this->createIndex(
            '{{%idx-unique-blog_id-user_id}}',
            '{{%likes}}',
            ['blog_id', 'user_id'],
            true
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-likes-user_id}}',
            '{{%likes}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-likes-user_id}}',
            '{{%likes}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `type`
        $this->createIndex(
            '{{%idx-likes-type}}',
            '{{%likes}}',
            'type'
        );

        // add foreign key for table `{{%likes_types}}`
        $this->addForeignKey(
            '{{%fk-likes-type}}',
            '{{%likes}}',
            'type',
            '{{%likes_types}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%blogs}}`
        $this->dropForeignKey(
            '{{%fk-likes-blog_id}}',
            '{{%likes}}'
        );

        // drops index for column `blog_id`
        $this->dropIndex(
            '{{%idx-likes-blog_id}}',
            '{{%likes}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-likes-user_id}}',
            '{{%likes}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-likes-user_id}}',
            '{{%likes}}'
        );

        // drops foreign key for table `{{%likes_types}}`
        $this->dropForeignKey(
            '{{%fk-likes-type}}',
            '{{%likes}}'
        );

        // drops index for column `type`
        $this->dropIndex(
            '{{%idx-likes-type}}',
            '{{%likes}}'
        );

        $this->dropTable('{{%likes}}');
    }
}
