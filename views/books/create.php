<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Forms\CreateBookForm;

/**
 * @var CreateBookForm $formModel
 * @var array $authors
 */
?>

<div class="row mt-3">
    <div class="col-12">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype'=>'multipart/form-data']
        ]); ?>
        <div class="row">
            <div class="col-6">
                <?= $form->field($formModel, 'title'); ?>
            </div>
            <div class="col-6">
                <?= $form->field($formModel, 'year'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <?= $form->field($formModel, 'isbn'); ?>
            </div>
            <div class="col-6">
                <?= $form->field($formModel, 'author_id')->dropDownList($formModel->getAuthorsList()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?= $form->field($formModel, 'picture')->fileInput() ; ?>
            </div>
            <div class="col-12">
                <?= $form->field($formModel, 'description')->textarea();?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
