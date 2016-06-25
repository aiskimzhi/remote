<?php
use app\models\Advert;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Adverts';
?>

<p class="headline">My Adverts</p>

<div id="gridVew">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showHeader' => false,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '0'],
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
                    return '<strong class="advert-title">' . Advert::countPrice($data->id) .
                    ' </strong><strong>' . strtoupper(Yii::$app->user->identity->getCurrency()) . '</strong>' .
                    '<br><br><br><br><br>Views: ' . $data->views;
                },
                'options' => ['class' => 'column'],
            ],
            [
                'class' => ActionColumn::className(),
                'options' => ['style' => 'width: 80px; max-width: 80px;'],
            ]
        ],
    ]) ?>
</div>