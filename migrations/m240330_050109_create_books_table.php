<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m240330_050109_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('books', [
            'id' => $this->primaryKey()->unsigned(),
            'title'=>$this->string(50)->notNull(),
            'year'=>$this->smallInteger()->unsigned()->notNull(),
            'isbn'=>$this->string(13)->unique()->notNull(),
            'picture'=>$this->string(),
            'description'=>$this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('books');
    }
}
