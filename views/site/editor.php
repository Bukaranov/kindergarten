<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редагування';

$form = ActiveForm::begin();
echo '<h1>Редагування головної сторінки</h1>';
//echo Html::textarea('text', $text, ['rows' => 10, 'style' => ['width' => '1070px']]);

echo TinyMce::widget([
    'name' => 'text',
    'value' => $text,
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'plugins' => [
            'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
            'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
            'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
        ],
        'toolbar' => 'undo redo | casechange blocks | bold italic backcolor | \
          alignleft aligncenter alignright alignjustify | \
          bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
    ]
]);

echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']);
ActiveForm::end();


?>
