<?php

namespace app\models;
use yii\db\ActiveRecord;

/**
 * @param integer $author_id
 * @param integer $book_id
 */
class AuthorBooks extends ActiveRecord
{
    public static function tableName()
    {
        return 'author_books';
    }
}