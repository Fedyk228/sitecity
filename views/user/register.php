<?php

/** @var controllers\SiteController $model */
/** @var controllers\SiteController $success */
/** @var controllers\SiteController $err */

use yii\bootstrap5\ActiveForm;

?>


<div class="row">
    <div class="col-sm-6 offset-3">
        <h1 class="s-title">Register</h1>

        <?php $form = ActiveForm::begin(); ?>
        <div class="py-1">
            <?= $form->field($model, 'fio')->textInput(); ?>
        </div>
        <div class="py-1">
            <?= $form->field($model, 'email')->textInput(); ?>
        </div>
        <div class="py-1">
            <?= $form->field($model, 'phone')->textInput(); ?>
        </div>
        <div class="py-1">
            <?= $form->field($model, 'password')->textInput(); ?>
        </div>
        <div class="py-1">
            <label class="form-label" for="users-r-password">Repeat password</label>
            <input type="text" id="users-r-password" class="form-control" name="r_password">
        </div>
        <div class="py-1">
            <button class="btn btn-success">Register</button>
            <a href="/web/user/login" class="btn btn-primary">Login</a>
        </div>

        <p class="text-success"><?= $success ?></p>
        <p class="text-danger"><?= $err ?></p>

        <?php ActiveForm::end(); ?>

    </div>
</div>
