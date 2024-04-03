<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_books}}`.
 */
class m240330_050150_create_authorBooks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('author_books', [
            'id' => $this->primaryKey(),
            'author_id'=> $this->integer()->unsigned()->notNull(),
            'book_id'=> $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-authors',
            'author_books',
            'author_id',
            'authors',
            'id',
        );
        $this->addForeignKey(
            'fk-books',
            'author_books',
            'book_id',
            'books',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('author_books');
    }
}
