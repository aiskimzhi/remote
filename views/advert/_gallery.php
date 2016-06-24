<?php

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $pictures app\models\Pictures */
/* @var $trash */
/* @var $buttons[] */
/* @var $model app\models\Advert */
?>

<div class="gallery">
    <?php for ($i = 0; $i < $pictures->imageAmount($model->id); $i++) : ?>
        <div class="border">
            <?php Modal::begin([
                'size' => 'my-modal',
                'toggleButton' => [
                    'label' => '',
                    'style' => 'background: url(' . $pictures->imgList(Yii::$app->request->get('id'))[$i] . ') no-repeat 50%; background-size: cover;',
                    'class' => 'toggle-button',
                    'onclick' => 'carouselOpen(' . $i . ')',
                ],
            ]);

            $items = $pictures->carouselItems($i, Yii::$app->request->get('id'));
            echo Carousel::widget([
                'id' => 'car' . $i,
                'items' => $items,
                'options' => [
                    'class' => 'modal-carousel',
                    'data-interval' => 'false',
                ],
            ]); ?>

            <?php Modal::end(); ?>
        </div>
    <?php endfor; ?>
</div>
