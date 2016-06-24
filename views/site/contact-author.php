<?php

/* @var $model app\models\ContactAuthor */
/* @var $receiver app\models\Advert */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Contact the author';
?>

<div class="site-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= Html::submitButton('Send email', ['class' => 'blue-button']) ?>

    <?php ActiveForm::end(); ?>
</div>
