<?php

namespace app\models;


use yii\base\Model;

class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $repeated_password;
    public $skype;
    public $phone;
    public $password_reset_token;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'repeated_password'], 'required'],
            [['first_name', 'last_name', 'email', 'skype', 'phone'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => 'app\models\User',
                'message' => 'This email address has already been taken'
            ],
            ['password', 'string', 'min' => 6],
            ['repeated_password', 'compare', 'compareAttribute' => 'password', 'operator' => '=='],
            ['password_reset_token', 'string', 'min' => 32, 'max' => 32],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->email = $this->email;
            $user->skype = $this->skype;
            $user->phone = $this->phone;
            $user->setPassword($this->password);
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
} 
