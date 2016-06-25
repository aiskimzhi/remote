<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "views".
 *
 * @property integer $user_id
 * @property integer $advert_id
 *
 * @property User $user
 * @property Advert $advert
 */
class Views extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'views';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'advert_id'], 'required'],
            [['user_id', 'advert_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['advert_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advert::className(), 'targetAttribute' => ['advert_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'advert_id' => 'Advert ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvert()
    {
        return $this->hasOne(Advert::className(), ['id' => 'advert_id']);
    }

    public function countViews($advert_id)
    {
        if (Yii::$app->user->isGuest
            && Views::findOne(['user_id' => Yii::$app->request->userIP, 'advert_id' => $advert_id]) == null) {
            $advert = Advert::findOne(['id' => $advert_id]);
            $this->user_id = Yii::$app->request->userIP;
            $this->advert_id = $advert_id;
            if ($this->save() && $advert->save()) {
                return true;
            }
        }
        if (!Yii::$app->user->isGuest
            && Views::findOne(['user_id' => Yii::$app->user->identity->getId(), 'advert_id' => $advert_id]) == null) {
            $advert = Advert::findOne(['id' => $advert_id]);
            if ($advert->user_id !== Yii::$app->user->identity->getId()) {
                $this->user_id = Yii::$app->user->identity->getId();
                $this->advert_id = $advert_id;
                $advert->views = $advert->views + 1;
                if ($this->save() && $advert->save()) {
                    return true;
                }
            }
        }

        return false;
    }
}
