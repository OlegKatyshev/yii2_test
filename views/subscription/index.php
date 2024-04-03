<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Forms\SubscribeForm;

/**
 * @var SubscribeForm $formModel
 * @var array $book_id
 */

?>
<div class="row mt-3">
    <div class="col-12">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <?= $form->field($formModel, 'book_id')->hiddenInput()->label(false) ?>
            <div class="col-6">
                <?= $form->field($formModel, 'phone')->label(false) ?>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>