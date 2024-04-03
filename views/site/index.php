<?php
use yii\data\Pagination;
use yii\helpers\Html;
/**
 * @var array $books
 * @var Pagination $pages
 */
?>
<div class="row">
    <div class="col-12 d-flex flex-wrap">
        <?php foreach ($books as $book):?>

        <?php $src = Yii::getAlias('@web/img/' . $book->picture);?>
        <div class="card mb-3 me-3 d-inline" style="width: 360px">
            <div class="row">
                <div class="col-5">
                    <img src="<?= $src ?>" class="card-img-top" style="width: 150px; height: 150px;">
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
