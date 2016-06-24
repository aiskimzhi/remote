<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ContactAuthor extends Model
{
    public $text;
    public $subject;
    
    public function rules()
    {
        return [
            [['text', 'subject'], 'required'],
            ['subject', 'string', 'max' => 64],
            ['text', 'string']
        ];
    }
    public function sendEmail($sender_email, $receiver_email, $subject, $model)
    {
        return Yii::$app->mailer->compose('contactAuthor', [
            'model' => $model
        ])
            ->setFrom($sender_email)
            ->setTo($receiver_email)
            ->setSubject($subject)
            ->send();
    }
}