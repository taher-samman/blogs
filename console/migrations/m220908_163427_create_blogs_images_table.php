<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blogs_images}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blogs}}`
 */
class m220908_163427_create_blogs_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blogs_images}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(),
            'value' => $this->text(),
        ]);

        // creates index for column `blog_id`
        $this->createIndex(
            '{{%idx-blogs_images-blog_id}}',
            '{{%blogs_images}}',
            'blog_id'
        );

        // add foreign key for table `{{%blogs}}`
        $this->addForeignKey(
            '{{%fk-blogs_images-blog_id}}',
            '{{%blogs_images}}',
            'blog_id',
            '{{%blogs}}',
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
            '{{%fk-blogs_images-blog_id}}',
            '{{%blogs_images}}'
        );

        // drops index for column `blog_id`
        $this->dropIndex(
            '{{%idx-blogs_images-blog_id}}',
            '{{%blogs_images}}'
        );

        $this->dropTable('{{%blogs_images}}');
    }
}
