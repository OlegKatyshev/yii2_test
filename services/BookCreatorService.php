<?php

namespace app\services;
use app\models\AuthorBooks;
use app\models\Books;
use app\models\Forms\CreateBookForm;

class BookCreatorService
{
    private Books $book;

    private AuthorBooks $authorBooks;

    private CreateBookForm $form;

    public function loadModels(Books $book, AuthorBooks $authorBooks, CreateBookForm $form): self{

        $this->book = $book;
        $this->authorBooks = $authorBooks;
        $this->form = $form;
        return $this;
    }

    public function save(){

        $transaction = Books::getDb()->beginTransaction();

        try{

            $this->book->attributes = $this->form->getAttributes();
            $this->book->savePicture()->save();

            $this->authorBooks->author_id = $this->form->author_id;
            $this->authorBooks->book_id = $this->book->id;
            $this->authorBooks->save();

            $transaction->commit();
        }
        catch (\Exception $e){
            $transaction->rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function update(){

        $transaction = Books::getDb()->beginTransaction();

        try{

            $oldPicture = $this->book->picture;
            $this->book->attributes = $this->form->getAttributes();
            if(empty($this->book->picture)) $this->book->picture = $oldPicture;
            $this->book->savePicture()->save();

            if($this->book->picture !== $oldPicture){
                $this->book->deletePicture($oldPicture);
            }

            AuthorBooks::deleteAll(['book_id'=>$this->book->id]);
            $this->authorBooks->author_id = $this->form->author_id;
            $this->authorBooks->book_id = $this->book->id;
            $this->authorBooks->save();

            $transaction->commit();
        }
        catch (\Exception $e){
            $transaction->rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}