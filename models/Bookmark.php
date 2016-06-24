<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookmark".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $advert_id
 *
 * @property User $user
 * @property Advert $advert
 */
class Bookmark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bookmark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'advert_id'], 'required'],
            [['user_id', 'advert_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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

//    public function picture($id)
//    {
//        $advert = Advert::findOne(['id' => $id]);
//        if (file_exists('img/page_' . $id)) {
//            if (count(scandir('img/page_' . $id)) > 2) {
//                if ($advert->avatar !== null) {
//                    return substr($advert->avatar, 1);
//                }
//                return 'img/page_' . $id . '/' . scandir('img/page_' . $id)[2];
//            }
//        }
//        return 'img/default.png';
//    }
}
