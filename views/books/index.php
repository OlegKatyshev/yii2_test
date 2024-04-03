<?php
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\Html;
/**
 * @var array $books
 * @var Pagination $pages
 */
?>
<div class="row mt-3">
    <div class="col-12">
        <?= Html::a('Создать книгу', ['books/create'],['class' => 'btn btn-secondary']) ?>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 d-flex flex-wrap">
        <?php foreach ($books as $book):?>

        <div class="card mb-3 me-3 d-inline" style="width: 360px">
            <div class="row">
                <div class="col-5">
                    <img src="<?= Yii::getAlias('@web/img/' . $book->picture) ?>" class="card-img-top" style="width: 150px; height: 150px;">
                </div>
                <div class="col-7">
                    <h5 class="card-title"><?= $book->title ?></h5>
                    <p class="card-text"><b>Год:</b> <?= $book->year ?></p>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text"><?= $book->description ?></p>
                <p class="card-text">
                    <?php $authorNames = ''; ?>

                    <?php foreach ($book->authors as $i => $author):?>
                    <?php $authorNames .= (($i>0) ? ', ': ' ') . $author->name . ' ' . $author->surname; ?>
                    <?php endforeach; ?>

                    <?php echo "<b>Авторы:</b>" . $authorNames; ?>
                </p>
                <?= Html::a('Подписаться', ['subscription/index','book_id'=>$book->id],['class' => 'btn btn-primary']) ?>
                <div class="row">
                    <div class="col-12 pt-2">
                        <a href="<?= Url::toRoute(['books/delete','id'=>$book->id]);?>" class="btn btn-danger">Удалить</a>
                        <a href="<?= Url::toRoute(['books/edit','id'=>$book->id]);?>" class="btn btn-light">Редактировать</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <?= \yii\bootstrap5\LinkPager::widget(['pagination'=>$pages]) ?>
    </div>
</div>
