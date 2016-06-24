<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign Up';
?>
<div class="site-form">

    <p class="headline">Sign Up</p>

    <?php $form = ActiveForm::begin([
        'id' => 'sign-up-form',
    ]); ?>

    <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Enter first name'])->label(false) ?>

    <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Enter last name'])->label(false) ?>

    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter e-mail'])->label(false) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter password'])->label(false) ?>

    <?= $form->field($model, 'repeated_password')->passwordInput(['placeholder' => 'Repeat password'])->label(false) ?>

    <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Enter your phone number'])->label(false) ?>

    <?= $form->field($model, 'skype')->textInput(['placeholder' => 'Enter skype'])->label(false) ?>

    <?= Html::submitButton('<strong>Sign Up</strong>', [
        'class' => 'blue-button', 'name' => 'login-button',
    ]) ?>

    <?php ActiveForm::end(); ?>
</div>
