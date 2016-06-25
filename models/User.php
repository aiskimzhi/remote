<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $skype
 * @property string $password_reset_token
 * @property string $currency
 *
 * @property Advert[] $adverts
 * @property Bookmark[] $bookmarks
 * @property Views[] $views
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password'], 'required'],
            [['first_name', 'last_name', 'email', 'password', 'phone', 'skype'], 'string', 'max' => 255],
            ['password_reset_token', 'string', 'max' => 64],
            ['password_reset_token', 'unique'],
            [
                ['first_name', 'last_name', 'email', 'phone', 'skype'], 'match',
                'pattern' => '/<script>/', 'not' => true,
                'message' => 'This field should not contain next symbols: ` ~ @ # $ % ^ & * / \\ < >',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'E-mail',
            'password' => 'Password',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'password_reset_token' => 'Password Reset Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdverts()
    {
        return $this->hasMany(Advert::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarks()
    {
        return $this->hasMany(Bookmark::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(Views::className(), ['user_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets current currency in DB
     *
     * @return string
     */
    public function getCurrency()
    {
        $user = User::findOne(['id' => Yii::$app->user->identity->getId()]);

        return $user->currency;
    }

    /**
     * Generates Full Name to show in Logout
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Finds user by [[email]]
     *
     * @param $email
     * @return null|static
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Generates passwordHash
     *
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates entered password
     *
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @return string
     */
    public function getPasswordResetToken()
    {
        return $this->password_reset_token;
    }

    /**
     * @param $password_reset_token
     * @return bool
     */
    public function validatePasswordResetToken($password_reset_token)
    {
        return $this->password_reset_token === $password_reset_token;
    }

    /**
     * removes password_reset_token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getAuthKey()
    {
        return true;
    }

    public function validateAuthKey()
    {
        return true;
    }
}