<?php

/** @var Yii\UserController\ $reviews */
/** @var Yii\UserController\ $author */

?>
<a href="/web/site" class="btn btn-primary">Go back</a>
<hr>
<h1>Reviews <?= $author['fio']; ?></h1>

<?php if($reviews) : ?>
<div class="row">
    <?php foreach ($reviews as $review) : ?>
    <div class="col-md-4 my-2">
        <div class="card">
            <div class="card-body">
                <em class="text-primary"><?= $review['date_create'] ?></em>
                <?php if($review['img']) : ?>
                <img src="/upload/<?= $review['img'] ?>" alt="" class="card-picture">
                <?php endif; ?>
                <h2 class="card-title"><?= $review['title'] ?></h2>
                <p><?= $review['text'] ?></p>
                <p><b>Rating: </b> <?= $review['rating'] ?></p>
                <p><b>City: </b> <?= $review['name'] ?> </p>


            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else : ?>
    <hr>
<h2 class="text-muted">Reviews not found</h2>
<?php endif; ?>
