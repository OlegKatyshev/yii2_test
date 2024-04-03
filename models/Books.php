<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\models\Authors;

/**
* @param string $title
* @param int $year
* @param int $isbn
* @param string $picture
* @param string $description
 */
class Books extends ActiveRecord
{

    public static function tableName()
    {
        return 'books';
    }

    public function rules()
    {
        return [
            [['title','year','isbn','description'], 'trim'],
            [['isbn','year'], 'integer'],
            [['description','title'], 'string'],
            ['picture', 'string'],
            ['isbn', 'unique', 'filter'=>function($query){
                if(!empty($this->id)){
                    return $query->andWhere(['not', ['id'=>$this->id]]);
                }
            } ],
       ];
    }

    public function getAuthors(){
        return $this->hasMany(Authors::class, ['id' => 'author_id'])
            ->viaTable('author_books', ['book_id' => 'id']);
    }

    public function deletePicture($oldFile): self {

        if(!empty($oldFile)) {

            $path = $this->getBookStorageAlias() . $oldFile;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return $this;
    }

    public function savePicture(): self {

        if($this->picture instanceof UploadedFile){

            $fileName = $this->picture->getBaseName() . $this->isbn;
            $fileName = $fileName . '.' . $this->picture->getExtension();
            $this->picture->saveAs($this->getBookStorageAlias() . $fileName);
            $this->picture = $fileName;
        }
        return $this;
    }

    private function getBookStorageAlias(): string{
        return \Yii::getAlias('@app/web/img/');
    }
}