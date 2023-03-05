<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>Название садика</td>
        <td>Вместимость</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $model) { ?>
        <tr>
            <td><?= $model->name ?></td>
            <td><?= $model->capacity ?></td>
        </tr>
    <? } ?>
    </tbody>
</table>