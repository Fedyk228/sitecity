<?php

/** @var controllers\SiteController $model */
/** @var controllers\SiteController $success */
/** @var controllers\SiteController $err */
/** @var controllers\SiteController $citys */


use yii\bootstrap5\ActiveForm;

?>

<h1>Citys</h1>

<?php $form=  ActiveForm::begin(); ?>

<div class="row align-items-center">
    <div class="col-md-8">
        <?= $form->field($model, 'name')->textInput(); ?>
    </div>
    <div class="col-md-4">
        <button class="btn btn-success">Add city</button>
    </div>
</div>

<?php ActiveForm::end(); ?>

<p class="text-success"><?= $success ?></p>
<p class="text-danger"><?= $err ?></p>


<hr>

<div class="row">
    <div class="col-md-8">
        <?php if($citys) : ?>

        <div class="list-group">
            <?php foreach ($citys as $city) : ?>
            <div class="list-group-item d-flex justify-content-between">
                <h4><?= $city['name']; ?></h4>

                <div>
                    <?php $form=  ActiveForm::begin(); ?>

                    <input type="hidden" name="id" value="<?= $city['id']; ?>">
                    <a href="/web/user/city-edit/<?= $city['id']; ?>" class="btn btn-success">Edit</a>
                    <button class="btn btn-danger">Remove</button>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
            <?php endforeach; ?>

        </div>

        <?php else :?>

        <h2 class="text-secondary">No citys</h2>

        <?php endif; ?>
    </div>
</div>





