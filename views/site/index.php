<?php

/* @var $rates */
$this->title = 'Welcome!';
?>

<div id="index-page" style="position: relative; overflow: hidden;">
    <div id="index-info" style="position: inherit; float: left;">
        <h1 id="welcome">Welcome to EURECA!</h1>

        <div class="index-info">
            <span class="glyphicon glyphicon-question-sign glyphicon-index"></span>
            <p class="index-page-1">
                Need to sell your goods or services but don’t how and know where?
            </p>

            <span class="glyphicon glyphicon-question-sign glyphicon-index"></span>
            <p class="index-page-1">Looking for something but still can’t find?</p>

            <span class="glyphicon glyphicon-question-sign glyphicon-index"></span>
            <p class="index-page-1">Join EURECA!</p>
        </div>

        <div class="index-info">
            <p class="index-page-2"><a href="signup.php">
                <strong>Sign Up</strong></a> or <a href="login.php"><strong>Login!</strong></a> and you'll be able to:
            </p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">place, update and delete your adverts</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">search for adverts in location and categories you want</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">add the most interesting adverts to bookmarks</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">communicate with authors and customers for more information and making a deal</p>

        </div>
    </div>


    <div id="exchange-rates">
        <p class="rates-1 rates-2">Exchange Rates according to the Ukrainian National Bank for today:</p>
        <?php foreach ($rates as $cur => $rate) : ?>
            <p class="rates-1"><strong class="rates-2 rates-3"><?= strtoupper($cur) ?>: </strong><?= $rate ?></p>
        <?php endforeach; ?>
    </div>
</div>