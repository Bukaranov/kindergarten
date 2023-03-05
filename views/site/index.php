<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Головна сторінка';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <div style="margin: 15px">
            <?= Html::a('Відправити запит', ['/site/create-request'], ['class'=>'btn btn-success']) ?>
        </div>
        <div style="">
            <?= Html::a('Мої заяви', ['/site/my-requests'], ['class'=>'btn btn-success']) ?>
        </div>
    </div>
</div>
