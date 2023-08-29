<?php

/** @var Yii\UserController\ $city */
/** @var Yii\UserController\ $reviews */

?>
<a href="/web/site" class="btn btn-primary">Go back</a>
<hr>
<h1>Reviews in <?= $city['name']; ?></h1>

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

                <?php if($login) : ?>
                <div class="author_btn">
                    <b>Author: </b>
                    <?= $review['fio'] ?>

                    <div class="author_info">
                        <p><b>email:</b> <?= $review['email'] ?></p>
                        <p><b>phone:</b> <?= $review['phone'] ?></p>
                        <hr>
                        <a href="/web/site/author/<?= $review['uid'] ?>" class="btn btn-primary">Read author reviews</a>
                    </div>
                </div>
                <?php else : ?>
                <p><b>Author: </b> <?= $review['fio'] ?></p>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else : ?>
    <hr>
<h2 class="text-muted">Reviews not found</h2>
<?php endif; ?>


<?php if($login) : ?>

<script>


    document.querySelectorAll('.author_btn').forEach((btn) => {
        btn.onclick = function()
        {
            this.querySelector('.author_info').style.display = 'block';
        }
    })

    document.onclick =function(e)
    {
        if(e.target.className != 'author_btn')
        {
            document.querySelectorAll('.author_info').forEach((info) => { info.style.display = 'none' })
        }
    }





</script>

<?php endif; ?>