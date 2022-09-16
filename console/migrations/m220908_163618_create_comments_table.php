<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blogs}}`
 * - `{{%user}}`
 */
class m220908_163618_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(),
            'user_id' => $this->integer(),
            'comment' => $this->string(255),
        ]);

        // creates index for column `blog_id`
        $this->createIndex(
            '{{%idx-comments-blog_id}}',
            '{{%comments}}',
            'blog_id'
        );

        // add foreign key for table `{{%blogs}}`
        $this->addForeignKey(
            '{{%fk-comments-blog_id}}',
            '{{%comments}}',
            'blog_id',
            '{{%blogs}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-comments-user_id}}',
            '{{%comments}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-comments-user_id}}',
            '{{%comments}}',
            'user_id',
            '{{%user}}',
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
            '{{%fk-comments-blog_id}}',
            '{{%comments}}'
        );

        // drops index for column `blog_id`
        $this->dropIndex(
            '{{%idx-comments-blog_id}}',
            '{{%comments}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-comments-user_id}}',
            '{{%comments}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-comments-user_id}}',
            '{{%comments}}'
        );

        $this->dropTable('{{%comments}}');
    }
}
