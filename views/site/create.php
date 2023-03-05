<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name'); ?>

    <?= $form->field($model, 'capacity'); ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>
