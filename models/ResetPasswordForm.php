<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $password;

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6]
        ];
    }
    
    public function resetPassword()
    {
        /* @var $user User */
        $user = User::findOne(['password_reset_token' => $_GET['token']]);
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save();
    }
}