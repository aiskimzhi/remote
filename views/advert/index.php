<?php

use app\models\Advert;
use app\models\Currency;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $regionList */
/* @var $cityList */
/* @var $disabled_city */
/* @var $catList */
/* @var $subcatList */
/* @var $disabled_subcat */
/* @var $beforeValue */
/* @var $afterValue */

$this->title = 'Adverts';

$sortBy = [
    '' => '<strong>Sort by: </strong>',
    '-updated_at' => 'Date decrement',
    'updated_at' => 'Date increment',
    '-u_price' => 'Price decrement',
    'u_price' => 'Price increment',
];
?>

<div class="advert-index">
    <div class="create-form">
    <?php $form = ActiveForm::begin(['id' => 'form-dropdown-search', 'method' => 'get']) ?>

    <div class="form-inline">
        <?= $form->field($searchModel, 'region_id', [
            'options' => ['class' => 'dropdown-left']
        ])->dropDownList($regionList,
            [
                'prompt'   => '- Choose a Region -',
                'style' => 'width: 79%;',
                'onchange' => '
                        $.ajax({
                            url: "' . Url::toRoute('get-city?id=') . '" + $(this).val(),
                            success: function( data ) {
                                $( "#' . Html::getInputId($searchModel, 'city_id') . '" )
                                .html( data ).attr("disabled", false);
                            }
                        });
                       '
            ])->label('Location: ', ['style' => 'width: 19%;']) ?>

        <?= $form->field($searchModel, 'city_id', [
            'options' => ['class' => 'dropdown-right']
        ])->dropDownList($cityList, [
                'value' => 'null',
                'prompt' => '- Choose a City -',
                'disabled' => $disabled_city,
                'style' => 'width: 100%;'
            ])->label(false) ?>
    </div>

    <div class="form-inline">
        <?= $form->field($searchModel, 'category_id', [
            'options' => ['class' => 'dropdown-left'],
        ])->dropDownList($catList,
            [
                'prompt'   => '- Choose a Category -',
                'style' => 'width: 79%;',
                'onchange' => '
                        $.ajax({
                            url: "' . Url::toRoute('get-subcat?id=') . '" + $(this).val(),
                            success: function( data ) {
                                $( "#' . Html::getInputId($searchModel, 'subcategory_id') . '" )
                                .html( data ).attr("disabled", false);
                            }
                        });
                       '
            ])->label('Category: ', ['style' => 'width: 19%;']) ?>

        <?= $form->field($searchModel, 'subcategory_id', [
            'options' => ['class' => 'dropdown-right']
        ])->dropDownList($subcatList, [
                'value' => 'null',
                'prompt' => '- Choose a Subcategory -',
                'disabled' => $disabled_subcat,
                'style' => 'width: 100%;'
            ])->label(false) ?>
    </div>

    <div class="form-inline">
        <label class="control-label" for="before-field" style="margin-left: 30px;">From: </label>
        <?= DatePicker::widget([
            'value' => $beforeValue,
            'name' => 'before',
            'id' => 'before-field',
            'options' => [
                'class' => 'form-control',
                'style' => 'width: 220px;',
                'onchange' => 'setMinDate()'
            ],
            'clientOptions' => [
                'maxDate' => 'new Date(0)',
            ]
        ]) ?>

        <label class="control-label" for="after-field">To: </label>
        <?= DatePicker::widget([
            'value' => $afterValue,
            'name' => 'after',
            'id' => 'after-field',
            'options' => ['class' => 'form-control', 'style' => 'width: 220px;'],
            'clientOptions' => [
                'maxDate' => 'new Date(0)',
            ]
        ]) ?>

        <a onclick="resetDate()" class="btn btn-primary">Other period</a>
    </div>
    <br>

    <div class="form-group">
        <?= Html::submitButton('Search', [
            'class' => 'blue-button',
            'name' => 'search',
            'value' => 'search'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

    <br>
    <div class="form-inline">
        <div class="form-group" style="width: 100%;">
            <form action="" method="get" id="sort">
                <select id="sort-drop" class="form-control" name="sort" onchange="this.form.submit()" style="width: 100%;">
                    <?php foreach ($sortBy as $col => $change) : ?>
                        <?php if (isset($_GET['sort']) && $_GET['sort'] == $col) : ?>
                            <option value="<?= $col ?>" selected="" style="width: 100%;"><?= $change ?></option>
                        <?php else : ?>
                            <option value="<?= $col ?>"><?= $change ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
    </div>

    <div id="gridVew">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showHeader' => false,
            'summaryOptions'=> ['style' => 'margin-bottom: 15px; margin-top: 20px;'],
            'tableOptions' => ['class' => 'table table-striped table-hover'],
            'columns' => [
                [
                    'label' => 'image',
                    'format' => 'html',
                    'value' => function($data) {
                        return Advert::getAvatar($data->id);
                    },
                    'options' => ['class' => 'column'],
                ],
                [
                    'label' => 'data',
                    'format' => 'html',
                    'value' => function($searchModel) {
                        $href = Url::toRoute('advert/view?id=') . $searchModel->id;
                        $text = '<div><strong class="advert-title"><a href="' .
                                $href . '"><font color="#000000"> ' . $searchModel->title .
                                '</font></a></strong></div>' . '<div>' . $searchModel->category->name .
                                ' » ' . $searchModel->subcategory->name . '</div><br><br><div>' .
                                $searchModel->region->name . ', ' . $searchModel->city->name . '</div>' .
                                date(Yii::$app->params['dateFormat'], $searchModel->updated_at);
                        return $text;
                    }
                ],
                [
                    'attribute' => 'price',
                    'format' => 'html',
                    'value' => function($data) {
                        $cur = Yii::$app->user->isGuest ? 'USD' : strtoupper(Yii::$app->user->identity->getCurrency());

                        return '<strong class="advert-title">' . Advert::countPrice($data->id) . 
                        ' </strong><strong>' . $cur . '</strong>';
                    },
                    'options' => ['class' => 'column'],
                ],
            ],
        ]) ?>
    </div>
</div>