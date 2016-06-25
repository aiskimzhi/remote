<?php

use app\models\Advert;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookmarkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Bookmarks';
?>

<p class="headline">My Bookmarks</p>

<div class="my-bookmarks">

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
                        return Advert::getAvatar($data->advert_id);
                    },
                    'options' => ['class' => 'column'],
                ],
                [
                    'label' => 'data',
                    'format' => 'html',
                    'value' => function($data) {
                        $href = Url::toRoute('advert/view?id=') . $data->advert_id;
                        $text = '<div><strong class="advert-title"><a href="' .
                            $href . '"><font color="#000000"> ' . $data->advert->title .
                            '</font></a></strong></div>' . '<div>' . $data->advert->category->name .
                            ' » ' . $data->advert->subcategory->name . '</div><br><br><div>' .
                            $data->advert->region->name . ', ' . $data->advert->city->name . '</div>' .
                            date(Yii::$app->params['dateFormat'], $data->advert->updated_at);
                        return $text;
                    }
                ],
                [
                    'attribute' => 'price',
                    'format' => 'html',
                    'value' => function($data) {
                        return '<strong class="advert-title">' . Advert::countPrice($data->advert_id) .
                        ' </strong><strong>' . strtoupper(Yii::$app->user->identity->getCurrency()) . '</strong>';
                    },
                    'options' => ['class' => 'column'],
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{delete}',
                    'options' => ['style' => 'width: 50px; max-width: 50px;'],
                ],
            ],
        ]) ?>
    </div>
</div>