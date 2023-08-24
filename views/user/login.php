<?php

/** @var controllers\SiteController $model */
/** @var controllers\SiteController $err */

use yii\bootstrap5\ActiveForm;

?>


<div class="row">
    <div class="col-sm-6 offset-3">
        <h1 class="s-title">Login</h1>

        <?php $form=  ActiveForm::begin(); ?>

        <div class="py-1">
            <?= $form->field($model, 'email')->textInput(); ?>
        </div>

        <div class="py-1">
            <?= $form->field($model, 'password')->textInput(); ?>
        </div>

        <div class="py-1">
            <button class="btn btn-success">Login</button>
            <a href="/web/user/register" class="btn btn-primary">Register</a>
        </div>

        <p class="text-danger"><?= $err ?></p>

        <?php ActiveForm::end(); ?>

    </div>
</div>
