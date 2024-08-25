<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_author_assignments}}`.
 */
class m240823_080830_create_book_author_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author_assignments}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('{{%pk-book_author_assignments}}', '{{%book_author_assignments}}', ['book_id', 'author_id']);
        $this->createIndex('{{%idx-book_author_assignments-book_id}}', '{{%book_author_assignments}}', 'book_id');
        $this->createIndex('{{%idx-book_author_assignments-author_id}}', '{{%book_author_assignments}}', 'author_id');
        $this->addForeignKey('{{%fk-book_author_assignments-book_id}}', '{{%book_author_assignments}}', 'book_id', '{{%books}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-book_author_assignments-author_id}}', '{{%book_author_assignments}}', 'author_id', '{{%authors}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_author_assignments}}');
    }
}
