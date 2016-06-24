<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Update Data';
?>

<div class="site-form">

    <p class="headline">Update Data</p>

    <?php $form = ActiveForm::begin([
        'id' => 'update-data',
    ]); ?>

    <?= $form->field($model, 'first_name')->textInput() ?>

    <?= $form->field($model, 'last_name')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'skype')->textInput() ?>

    <?= Html::submitButton('<strong>Change data</strong>', [
        'class' => 'blue-button', 'name' => 'login-button',
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
