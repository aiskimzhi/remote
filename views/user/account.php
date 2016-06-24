<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

use yii\helpers\Html;

$this->title = 'My Account';
?>

<div class="account">

    <div class="account-left">
        <?= Html::a('My Adverts', ['advert/my-adverts'], [
            'class' => 'account-button account-button-blue'
        ]) ?>

        <?= Html::a('My Bookmarks', ['bookmark/my-bookmarks'], [
            'class' => 'account-button account-button-blue'
        ]) ?>

        <?= Html::a('Update Data', ['user/update-data'], [
            'class' => 'account-button account-button-blue'
        ]) ?>

        <?= Html::a('Change Password', ['user/change-password'], [
            'class' => 'account-button account-button-blue'
        ]) ?>

        <?= Html::a('Delete Account', ['user/delete-account'], [
            'class' => 'account-button account-button-delete'
        ]) ?>

    </div>

    <div class="account-right">
        <p class="headline"><?= $model->getFullName() ?></p>
        <p style="padding-left: 7%;"><em>My contacts: </em></p>
        <p style="padding-left: 7%;"><strong>E-mail: </strong><?= $model->email ?></p>
        <p style="padding-left: 7%;"><strong>Phone: </strong><?= $model->phone ?></p>
        <p style="padding-left: 7%;"><strong>Skype: </strong><?= $model->skype ?></p>
    </div>

    <div class="account-create-advert">
        <?= Html::a('Create Advert', ['advert/create'], ['class' => 'blue-button create-button']) ?>
    </div>

</div>
