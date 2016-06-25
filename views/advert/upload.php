<?php

use app\models\Advert;
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\UploadForm */
/* @var $user app\models\User */
/* @var $adv app\models\Advert */

$this->title = 'Upload Pictures';
?>

<div class="site-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
        'options' => ['multiple' => true],
        'pluginOptions' => ['previewFileType' => 'any']
    ]) ?>

    <?= Html::a('Skip this step', [Url::toRoute(['view', 'id' => Advert::getId()])], ['class' => 'btn btn-primary']) ?>


    <?php ActiveForm::end(); ?>

</div>
