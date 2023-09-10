<?php

/** @var controllers\SiteController $model */
/** @var controllers\SiteController $success */
/** @var controllers\SiteController $err */

use yii\bootstrap5\ActiveForm;


?>

<a href="/web/user" class="btn btn-primary">Go back</a>

<hr>

<h1>Review edit</h1>


<?php $form=  ActiveForm::begin(); ?>

<div class="row align-items-center">
    <div class="col-md-8">
        <?= $form->field($model, 'title')->textInput(); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'text')->textarea(); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'rating')->dropDownList([
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5
        ]); ?>
    </div>
    <div class="col-md-8">

        <?php if($model->img != '') : ?>
            <img src="/upload/<?= $model->img ?>" alt="" class="preview">
        <?php endif; ?>

        <?= $form->field($model, 'img')->fileInput(); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'id_city')->dropDownList($citys); ?>
    </div>

    <div class="col-md-4">
        <button class="btn btn-success">Save review</button>
    </div>
</div>

<?php ActiveForm::end(); ?>

<p class="text-success"><?= $success ?></p>
<p class="text-danger"><?= $err ?></p>