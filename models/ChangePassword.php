<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePassword extends Model
{
    public $oldPassword;
    public $password;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['oldPassword', 'password', 'confirmPassword'], 'required'],
            ['password', 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'operator' => '==']
        ];
    }

    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Current password',
            'password' => 'New password',
            'confirmPassword' => 'Confirm new password'
        ];
    }

    public function changePassword()
    {
        $user = User::findOne(['id' => Yii::$app->user->identity->getId()]);

        if (Yii::$app->request->post()) {
            if (Yii::$app->security->validatePassword(
                    Yii::$app->request->post('ChangePassword')['oldPassword'], $user->password)
                ) {
                $user->password = Yii::$app->security->generatePasswordHash(
                    Yii::$app->request->post('ChangePassword')['password']
                );
                if ($user->save()) {
                    return true;
                }
            }
        }

        return null;
    }
} 
