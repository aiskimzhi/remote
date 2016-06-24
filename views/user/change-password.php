<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ChangePassword */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change Password';
?>

<div class="site-form">

    <p class="headline">Change Password</p>

    <?php $form = ActiveForm::begin([
        'id' => 'change-password',
    ]); ?>

    <?= $form->field($model, 'oldPassword')->passwordInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

    <?= Html::submitButton('<strong>Change password</strong>', [
        'class' => 'blue-button', 'name' => 'login-button',
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
