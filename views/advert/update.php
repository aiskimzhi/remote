<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Advert */
/* @var $catList */
/* @var $subcatList */
/* @var $regionList */
/* @var $cityList */

$this->title = 'Update Advert: ' . ' ' . $model->title;
?>

<div class="create-form">

    <?php $form = ActiveForm::begin(['id' => 'form']); ?>

    <div class="form-inline">
        <?= $form->field($model, 'category_id', [
            'options' => ['class' => 'dropdown-left']
        ])->dropDownList($catList,
            [
                'style' => 'width: 79%;',
                'onchange' => '
                                    $.ajax({
                                        url: "' . Url::toRoute('get-subcat?id=') . '" + $(this).val(),
                                        success: function( data ) {
                                            $( "#' . Html::getInputId($model, 'subcategory_id') . '" )
                                            .html( data ).attr("disabled", false);
                                        }
                                    });
                                   '
            ])->label('Category: ', ['style' => 'width: 19%;'])
            ->error(['class' => 'help-block help-block-error', 'style' => 'margin-left: 20%;']) ?>

        <?= $form->field($model, 'subcategory_id', [
            'options' => ['class' => 'dropdown-right']
        ])->dropDownList($subcatList, ['style' => 'width: 100%;'])->label(false) ?>
    </div>

    <div class="form-inline">
        <?= $form->field($model, 'region_id', [
            'options' => ['class' => 'dropdown-left'],
        ])->dropDownList($regionList,
            [
                'style' => 'width: 79%;',
                'onchange' => '
                                    $.ajax({
                                        url: "' . Url::toRoute('get-city?id=') . '" + $(this).val(),
                                        success: function( data ) {
                                            $( "#' . Html::getInputId($model, 'city_id') . '" )
                                            .html( data ).attr("disabled", false);
                                        }
                                    });
                                   '
            ])->label('Location: ', ['style' => 'width: 19%;'])
            ->error(['class' => 'help-block help-block-error', 'style' => 'margin-left: 20%;']) ?>

        <?= $form->field($model, 'city_id', [
            'options' => ['class' => 'dropdown-right'],
        ])->dropDownList($cityList, ['style' => 'width: 100%;'])->label(false) ?>
    </div>

    <div id="advert-update">
        <?= $form->field($model, 'title')->textInput() ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

        <div class="form-inline">
            <?= $form->field($model, 'price', [
                'options' => ['style' => 'height: 69px; float: left;']
            ])->textInput() ?>

            <?= $form->field($model, 'currency', [
                'options' => ['style' => 'height: 69px;']
            ])->dropDownList(
                array_flip(array_change_key_case(array_combine(
                    Yii::$app->params['currency'], Yii::$app->params['currency']
                ), CASE_UPPER))
            )->label(false) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Update Advert', ['class' => 'blue-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
