<?php

/** @var Yii\SiteController\ $login */
/** @var Yii\SiteController\ $currentCity */
/** @var Yii\SiteController\ $citys */

?>
<?php


?>

<?php if($login) :
        if($currentCity) :
    ?>
        <h1>Your city <?= $currentCity['name']; ?>?</h1>
            <a href="/web/site/city/<?= $currentCity['id'] ?>" class="btn btn-primary">Go reviews</a>

            <hr>
    <h1>or</h1>
    <?php endif; ?>
    <h1>Change city</h1>

    <?php if($citys) : ?>
     <ul class="list-group">
         <?php foreach($citys as $city) : ?>
        <li class="list-group-item">
            <a href="/web/site/city/<?= $city['id'] ?>"><?= $city['name'] ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>


<?php
        else : ?>

    <div class="py-3 text-center">
        <h1>Please login</h1>
        <a href="/web/user/login" class="btn btn-success">Go login</a>
    </div>


<?php endif; ?>