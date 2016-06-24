<?php

namespace app\controllers;

use app\models\Advert;
use app\models\ContactAuthor;
use app\models\Currency;
use app\models\ResetPasswordForm;
use app\models\SendEmailForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
//                    [
//                        'actions' => ['login'],
//                        'allow' => false,
//                        'roles' => ['?']
//                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $rates = Currency::getExchangeRates();
        array_pop($rates);

        return $this->render('index', [
            'rates' => $rates,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['user/account']);
        }

       $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['user/account']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(['user/account']);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * sends an email with token to reset the password
     * 
     * @return string|\yii\web\Response
     */
    public function actionSendEmail()
    {
        $model = new SendEmailForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                Yii::$app->getSession()->setFlash('success', 'Check your mailbox');
                $model->sendEmail();
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Cannot send email');
            }
        }
        
        return $this->render('send-email', [
            'model' => $model,
        ]);
    }

    /**
     * resets password if the token is ok
     * 
     * @return string|\yii\web\Response
     */
    public function actionResetPassword()
    {
        $model = new ResetPasswordForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->resetPassword();
                Yii::$app->getSession()->setFlash('success', 'Your password was changed successfully.');
                return $this->goHome();
            }
        }
        
        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    public function actionContactAuthor($id)
    {
        $model = new ContactAuthor();

        $receiver = Advert::findOne(['id' => $id]);
        $sender = User::findOne(['id' => Yii::$app->user->identity->getId()]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->sendEmail($sender->email, $receiver->user->email, $model->subject, $model)) {
                Yii::$app->getSession()->setFlash('success', 'Your email was sent successfully');
                return $this->redirect(['advert/view?id=' . $id]);
            }
        }
        
        return $this->render('contact-author', [
            'model' => $model,
            'receiver' => $receiver,
            'sender' => $sender,
        ]);
    }
}
