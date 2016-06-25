<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "advert".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $region_id
 * @property integer $city_id
 * @property integer $category_id
 * @property integer $subcategory_id
 * @property string $title
 * @property string $text
 * @property string $price
 * @property string $currency
 * @property string $u_price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $views
 * @property string $avatar
 *
 * @property User $user
 * @property Region $region
 * @property City $city
 * @property Category $category
 * @property Subcategory $subcategory
 * @property Bookmark[] $bookmarks
 * @property Views[] $views0
 */
class Advert extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'price', 'currency'], 'required'],
            [['user_id', 'region_id', 'city_id', 'category_id', 'subcategory_id', 'created_at', 'updated_at', 'views'], 'integer'],
            [['text'], 'string'],
            [['price', 'u_price'], 'number'],
            [['title', 'avatar'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            ['region_id', 'required', 'message' => 'Region cannot be blank'],
            ['city_id', 'required', 'message' => 'City cannot be blank'],
            ['category_id', 'required', 'message' => 'Category cannot be blank'],
            ['subcategory_id', 'required', 'message' => 'Subcategory cannot be blank'],
            [
                ['title', 'text'], 'match',
                'pattern' => '/[a-zA-Z0-9!\?,\.:;\(\)]/',
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
            'user_id' => 'User ID',
            'region_id' => 'Region ID',
            'city_id' => 'City ID',
            'category_id' => 'Category ID',
            'subcategory_id' => 'Subcategory ID',
            'title' => 'Title',
            'text' => 'Text',
            'price' => 'Price',
            'currency' => 'Currency',
            'u_price' => 'U Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'views' => 'Views',
            'avatar' => 'Avatar',
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
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::className(), ['id' => 'subcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarks()
    {
        return $this->hasMany(Bookmark::className(), ['advert_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViews0()
    {
        return $this->hasMany(Views::className(), ['advert_id' => 'id']);
    }

    /**
     * Creates new advert
     *
     * @return Advert|null
     */
    public function createAdvert()
    {
        $currency = Currency::find()->where(['date' => 0])->asArray()->one();
        if ($this->validate()) {
            $advert = new Advert;
            $advert->user_id = Yii::$app->user->identity->getId();
            $advert->category_id = $this->category_id;
            $advert->subcategory_id = $this->subcategory_id;
            $advert->region_id = $this->region_id;
            $advert->city_id = $this->city_id;
            $advert->title = $this->title;
            $advert->text = $this->text;
            $advert->price = $this->price;
            $advert->currency = $this->currency;
            $advert->u_price = $this->price * $currency[$this->currency];
            $advert->created_at = time();
            $advert->updated_at = time();
            $advert->views = 0;
            if ($advert->save()) {
                return $advert;
            }
        }
        return null;
    }

    /**
     * returns phone and skype of the user
     * 
     * @param $userId
     * @return mixed
     */
    public function getContacts($userId)
    {
        $user = User::findOne(['id' =>$userId]);
        $notSet = '<span class="not-set">not set</span>';
        if (Yii::$app->user->isGuest || $userId !== Yii::$app->user->identity->getId()) {
            $contacts['Phone'] = empty($user->phone) ? '' : $user->phone;
            $contacts['Skype'] = empty($user->skype) ? '' : $user->skype;
        } else {
            $contacts['Phone'] = empty($user->phone) ? $notSet : $user->phone;
            $contacts['Skype'] = empty($user->skype) ? $notSet : $user->skype;
        }
        return $contacts;
    }

    /**
     * returns e-mail or a link to contact the author by e-mail
     *
     * @param $userId
     * @return string
     */
    public function contact($userId)
    {
        $user = User::findOne(['id' =>$userId]);
        if (Yii::$app->user->isGuest || $userId !== Yii::$app->user->identity->getId()) {
            $contact = '<p class="contact">Contact the author: ' . $user->getFullName() . '</p>';
            $contact .= '<p><a href="' . Url::toRoute(['site/contact-author', 'id' => $_GET['id']]) . '">
                        <strong>Write an e-mail</strong></a></p>';
        } else {
            $contact = '<p class="contact">My contacts: </p>';
            $contact .= '<p><strong>E-mail: </strong>' . $user->email . '</p>';
        }
        return $contact;
    }

    /**
     * deletes picture
     * 
     * @return mixed
     */
    public function deletePic()
    {
        $advert = Advert::findOne(['id' => $_GET['id']]);
        
//        $a = substr($_POST['delete_pic'], 1);
        $un = '/home/vol3_3/byethost7.com/b7_18395569/htdocs' . $_POST['delete_pic'];
//        $un = Yii::$app->urlManager->createAbsoluteUrl($a);
//        var_dump($un); die;
        
        if ($_POST['delete_pic'] == $advert->avatar) {
            $advert->avatar = null;
            if ($advert->save()) {
                return unlink($un);
            }
        }
        
        return unlink($un);
    }

    public static function getId()
    {
        $advert = Advert::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->orderBy('id DESC')
            ->asArray()
            ->one();
        return $advert['id'];
    }

    /**
     * It is a static copy of method picture()
     * 
     * @param $id
     * @return string
     */
    public static function getAvatar($id)
    {
        $src = Yii::$app->urlManager->createAbsoluteUrl('web/img/default.png');
        $advert = Advert::findOne(['id' => $id]);
        
        if (file_exists('img/page_' . $id)) {
            if (count(scandir('img/page_' . $id)) > 2) {
                $src = Yii::$app->urlManager->createAbsoluteUrl(
                    'web/img/page_' . $id . '/' . scandir('img/page_' . $id)[2]
                );
                
                if ($advert->avatar !== null) {
                    $src = Yii::$app->urlManager->createAbsoluteUrl(substr($advert->avatar, 1));
                }
            }
        }

        return Html::a(Html::img($src, ['class' => 'avatar']), [Url::toRoute(['advert/view', 'id' => $id])]);
    }

    /**
     * gets the price according to a chosen currency
     *
     * @param $id
     * @return mixed
     */
    public static function countPrice($id)
    {
        $advert = Advert::find()->where(['id' => $id])->asArray()->one();
        $rates = Yii::$app->user->isGuest ? Currency::getExchangeRates()['usd'] :
            Currency::getExchangeRates()[Yii::$app->user->identity->getCurrency()];

        return round($advert['price'] * Currency::getExchangeRates()[$advert['currency']] / $rates, 2);
    }

    /**
     * shows if the string is a date
     *
     * @param $date
     * @return bool
     */
    public static function isDate($date)
    {
        if (is_numeric(strtotime($date))) {
            return true;
        }

        return false;
    }
}
