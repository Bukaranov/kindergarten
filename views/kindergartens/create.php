<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kindergartens $model */

$this->title = 'Створити дитячі садки';
$this->params['breadcrumbs'][] = ['label' => 'Kindergartens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kindergartens-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
