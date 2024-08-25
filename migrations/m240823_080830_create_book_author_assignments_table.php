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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_author_assignments}}');
    }
}
