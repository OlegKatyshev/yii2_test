<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Forms\AuthorsForm;

/**
 * @var AuthorsForm $formModel
 * @var array $years
 * @var array $authors
 */

?>
<div class="row mt-3">
    <div class="col-12">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-6">
                <?= $form->field($formModel, 'year')->dropDownList(array_combine($years, $years))->label(false) ?>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <?= Html::submitButton('Отчет', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Сбросить', ['authors/clear'],['class' => 'btn btn-secondary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <?php if(!empty($authors)): ?>
        <div class="col-12">
            <ul class="list-group list-group-flush">
                <?php foreach($authors as $author): ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-12"><b>Автор:</b> <?= $author['name']?> <?= $author['surname']?></div>
                            <div class="col-12"><b>Публикаций:</b> <?= $author['cnt_publish']?></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
