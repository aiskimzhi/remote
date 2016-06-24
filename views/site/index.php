<?php

/* @var $rates */
$this->title = 'Site/Index';
?>

<div id="index-page" style="position: relative; overflow: hidden;">
    <div id="index-info" style="position: inherit; float: left;">
        <h1 id="welcome">Welcome to EURICA!</h1>

        <div class="index-info">
            <span class="glyphicon glyphicon-question-sign glyphicon-index"></span>
            <p class="index-page-1">
                You need to place an advert about selling your goods or services but don’t know where?
            </p>

            <span class="glyphicon glyphicon-question-sign glyphicon-index"></span>
            <p class="index-page-1">You are looking for something but still can’t find?</p>

            <span class="glyphicon glyphicon-question-sign glyphicon-index"></span>
            <p class="index-page-1">You need to join EURICA!</p>
        </div>

        <div class="index-info">
            <p class="index-page-2">After you <a href="signup.php"><strong>Sign Up</strong></a> you will be able to:</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">place, update and delete your adverts</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">search for adverts in location and categories you want</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">add the most interesting adverts to bookmarks</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">contact authors for more information and making a deal</p>

            <span class="glyphicon glyphicon-ok glyphicon-ok-list"></span>
            <p class="index-page-3">other users will also be able to contact you to get your goods or services</p>

        </div>

        <p class="index-page-2">Already have an account? Just <a href="login.php"><strong>Login!</strong></a></p>
    </div>


    <div id="exchange-rates">
        <p class="rates-1 rates-2">Exchange Rates according to the Ukrainian National Bank for today:</p>
        <?php foreach ($rates as $cur => $rate) : ?>
            <p class="rates-1"><strong class="rates-2 rates-3"><?= strtoupper($cur) ?>: </strong><?= $rate ?></p>
        <?php endforeach; ?>
    </div>
</div>