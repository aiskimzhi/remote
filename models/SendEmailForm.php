<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SendEmailForm extends Model
{
    public $email;
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        ];
    }
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'email' => $this->email,
        ]);
        if ($user) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                return Yii::$app->mailer->compose('resetPassword', ['user' => $user])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($this->email)
                    ->setSubject('Reset password')
                    ->send();
            }
        }
        return false;
    }
}