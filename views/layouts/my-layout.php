<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\AlertWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/css/custom.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php $this->beginBody() ?>
<div class="my-wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'EURECA',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-my navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        $items = [
            ['label' => 'Login', 'url' => ['/site/login']],
            ['label' => 'Sign Up', 'url' => ['/site/signup']]
        ];
    } else {
        for ($i = 0; $i < count(Yii::$app->params['currency']); $i++) {
            if (Yii::$app->params['currency'][$i] == Yii::$app->user->identity->getCurrency()) {
                $currency[$i] = '<option selected id="opt' .
                    $i . '" value="' . Yii::$app->params['currency'][$i] . '">' .
                    strtoupper(Yii::$app->params['currency'][$i]) . '</option>';
            } else {
                $currency[$i] = '<option id="opt' . $i . '" value="' . Yii::$app->params['currency'][$i] . '">' .
                    strtoupper(Yii::$app->params['currency'][$i]) . '</option>';
            }
        }

        $select = '<select class="navbar-nav navbar-right top-menu form-control"
                    style="width: 100px; margin-top: 10px;"
                    onchange="insertCurrency()"
                    name="' . Yii::$app->urlManager->createAbsoluteUrl(['user/insert-currency']) . '"
                    id="select-currency">';
        foreach ($currency as $cur) {
            $select .= $cur;
        }
        $select .= '</select>';

        $items = [
            ['label' => 'Adverts', 'url' => ['/adverts']],
            ['label' => 'Create Advert', 'url' => ['/advert/create']],
            ['label' => 'My Account', 'url' => ['/user/account']],
            [
                'label' => 'Logout (' . Yii::$app->user->identity->getFullName() . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right top-menu'],
        'items' => $items,
    ]);

    if (!Yii::$app->user->isGuest) {
        echo $select;
    }

    NavBar::end();
    ?>

    <div class="my-container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= AlertWidget::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; EURECA <?= date('Y') ?></p>

        <p class="pull-right">Powered by Yii Framework</p>
    </div>
</footer>

<?php $this->endBody() ?>
<script src="/js/custom.js" type="text/javascript"></script>
</body>
</html>
<?php $this->endPage() ?>
