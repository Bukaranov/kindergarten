<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Kindergartens $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Дитячі садки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kindergartens-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Оновлення', ['update', 'kindergarten_id' => $model->kindergarten_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'kindergarten_id' => $model->kindergarten_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kindergarten_id',
            'name',
            'capacity',
        ],
    ]) ?>

</div>
