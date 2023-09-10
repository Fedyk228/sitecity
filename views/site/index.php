<?php

/** @var Yii\SiteController\ $login */
/** @var Yii\SiteController\ $currentCity */
/** @var Yii\SiteController\ $citys */

?>
<?php


?>

<?php
        if($currentCity) :
    ?>
        <h1>Your city <?= $currentCity['name']; ?>?</h1>
            <a href="/web/site/city/<?= $currentCity['cid'] ?>" class="btn btn-primary">Go reviews</a>

            <hr>
    <h1>or</h1>
    <?php endif; ?>
    <h1>Change city</h1>

    <?php if($citys) : ?>
     <ul class="list-group">
         <?php foreach($citys as $city) : ?>
        <li class="list-group-item">
            <a href="/web/site/city/<?= $city['cid'] ?>"><?= $city['name'] ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
        <h1 class="text-danger">Cities not found</h1>
    <?php endif; ?>
