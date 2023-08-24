<?php

/** @var controllers\SiteController $model */
/** @var controllers\SiteController $success */
/** @var controllers\SiteController $err */

use yii\bootstrap5\ActiveForm;


?>

<a href="/web/user" class="btn btn-primary">Go citys</a>

<hr>

<h1>City edit</h1>


<?php $form=  ActiveForm::begin(); ?>

<div class="row align-items-center">
    <div class="col-md-8">
        <?= $form->field($model, 'name')->textInput(); ?>
    </div>
    <div class="col-md-4">
        <button class="btn btn-success">Save city</button>
    </div>
</div>

<?php ActiveForm::end(); ?>

<p class="text-success"><?= $success ?></p>
<p class="text-danger"><?= $err ?></p>