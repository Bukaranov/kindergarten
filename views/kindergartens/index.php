<?php

use app\models\Kindergartens;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\KindergartensSerch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Kindergartens $model */


$this->title = 'Дитячі садки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kindergartens-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Створити дитячі садки', ['create'], ['class' => 'btn btn-success']) ?>

    </p>

    <?php // Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'name',
            'capacity',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Kindergartens $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'kindergarten_id' => $model->kindergarten_id]);
                 }
            ],
        ],
    ]); ?>

    <?php // Pjax::end(); ?>

</div>
