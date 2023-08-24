<?php

/** @var Yii\UserController\ $success */

?>
<div class="text-center">
    <?php if($success) : ?>
    <h1>Your account activated success!</h1>
        <hr>

        <a href="/web/user/login" class="btn btn-primary">Please login</a>
    <?php else : ?>
    <h1 class="text-danger">Error activate account</h1>
        <hr>

        <a href="/web/site/" class="btn btn-primary">Go home page</a>
    <?php endif; ?>


</div>



