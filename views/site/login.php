<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="site-form">

    <p class="headline">Login</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail'])->label(false) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?= Html::submitButton('<strong>Login</strong>', [
        'class' => 'blue-button', 'name' => 'login-button',
    ]) ?>

    <?php ActiveForm::end(); ?>
</div>

<div style="margin-top: 25px;"><?= Html::a('Forgot password?', ['send-email'])?></div>