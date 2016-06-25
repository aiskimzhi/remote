<?php

use app\models\Advert;
use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Advert */
/* @var $contacts */
/* @var $contact */
/* @var $value */
/* @var $buttons[] */
/* @var $trash */
/* @var $gallery */
/* @var $pictures app\models\Pictures */
/* @var $upload app\models\UploadForm */

$this->title = $model->title;
?>
<div class="advert-view">

    <div class="category"><?= $model->category->name ?> » <?= $model->subcategory->name ?></div>

    <div class="title"><?= $model->title ?></div>

    <div class="region"><?= $model->region->name ?>, <?= $model->city->name ?></div>

    <div class="date-update">
        Last update: <?= date(Yii::$app->params['dateFormat'], $model->updated_at) ?>
    </div>

<?php
   echo $this->render($gallery, [
       'pictures' => $pictures,
       'model' => $model,
       'upload' => $upload,
   ]);
?>

    <div class="advert-text">
        <?= $model->text ?>

        <br><br>
        
        <div class="advert-title">
            <strong>Price: </strong><?= Advert::countPrice($model->id) ?>
            <?= strtoupper(Yii::$app->user->isGuest ? 'usd' : Yii::$app->user->identity->getCurrency()) ?>
        </div>
    </div>

    <div class="contacts">
        <?= $contact ?>
        <?php foreach ($contacts as $mean => $cont) : ?>
            <?php if (!empty($cont)) : ?>
                <p><strong><?= $mean ?>: </strong><?= $cont ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="advert-buttons">
        <?php $url = Url::toRoute(['bookmark/add-to-bookmarks', 'id' => $model->id]); ?>
        <?= Yii::$app->user->isGuest ? '' : Html::input('submit', 'button', $value,
            [
                'id' => 'book',
                'class' => 'btn btn-primary',
                'onclick' => '
                        $.ajax({
                        url: "' . $url . '",
                        success: function ( data ) {
                            $( "#book" ).html( data ).attr("value", data );
                        }
                        })
                    '
            ])
        ?>

        <?= $buttons['update'] ?> <?= $buttons['delete'] ?>
    </div>

</div>


