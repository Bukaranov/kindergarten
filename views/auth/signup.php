<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Реєстрація';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Будь ласка, заповніть наступні поля для реєстрації:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'full_name')->label('Прізвище ім\'я по батькові')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'login')->label('Логін')->textInput() ?>

    <?= $form->field($model, 'password')->label('Пароль')->passwordInput() ?>


    <div class="form-group">
        <div class="offset-lg-1 col-lg-11">
            <?= Html::submitButton('Зареєструватись', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
