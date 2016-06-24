<?php

/* @var $user \app\models\User */

use yii\helpers\Html;
?>

<p><?= 'Hello ' . Html::encode($user->getFullName()) . '!' ?></p>

<p><?= Html::a('Follow the link to change your password',
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            'site/reset-password',
            'token' => $user->password_reset_token,
        ]
    )
) ?></p>