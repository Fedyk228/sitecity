<?php

/** @var controllers\UserController $model */
/** @var controllers\UserController $reviews */
/** @var controllers\UserController $success */
/** @var controllers\UserController $err */
/** @var controllers\UserController $citys */


use yii\bootstrap5\ActiveForm;

?>

<h1>Cabinet - Reviews</h1>

<?php $form=  ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

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
        <?= $form->field($model, 'img')->fileInput(); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'id_city')->dropDownList($citys); ?>
    </div>

    <div class="col-md-4">
        <button class="btn btn-success">Add review</button>
    </div>
</div>

<?php ActiveForm::end(); ?>

<p class="text-success"><?= $success ?></p>
<p class="text-danger"><?= $err ?></p>


<hr>

<div class="row">
    <div class="col-md-8">
        <?php if($reviews) : ?>

            <div class="list-group">
                <?php foreach ($reviews as $review) : ?>
                    <div class="list-group-item d-flex justify-content-between">
                        <div>
                            <em class="text-primary"><?= $review['date_create']; ?></em>
                            <h4><?= $review['title']; ?></h4>
                        </div>


                        <div>
                            <?php $form=  ActiveForm::begin(); ?>

                            <input type="hidden" name="id" value="<?= $review['id']; ?>">
                            <a href="/web/user/review-edit/<?= $review['id']; ?>" class="btn btn-success">Edit</a>
                            <button class="btn btn-danger">Remove</button>

                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        <?php else :?>

            <h2 class="text-secondary">No reviews</h2>

        <?php endif; ?>
    </div>
</div>





