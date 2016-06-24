<?php

namespace app\models;

use SimpleXMLElement;
use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $date
 * @property string $usd
 * @property string $eur
 * @property string $rur
 * @property string $uan
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'usd', 'eur', 'rur', 'uan'], 'required'],
            [['date'], 'integer'],
            [['usd', 'eur', 'rur', 'uan'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'usd' => 'Usd',
            'eur' => 'Eur',
            'rur' => 'Rur',
            'uan' => 'Uan',
        ];
    }

    /**
     * I AM NOT SURE I NEED THIS METHOD AND MAYBE I SHOULD DELETE IT
     *
     * @param $id
     * @return null|static
     */
    public function insertCurrency($id)
    {
        $user = User::findOne(['id' => $id]);
        $user->currency = $_POST['cur'];
        if ($user->save()) {
            return $user;
        }
        return null;
    }

    /**
     * Uses PrivatBank API
     *
     * @return bool
     */
    public function exchangeRates()
    {
        if (Currency::find()->where(['>', 'date', time()])->asArray()->all() == null) {
            $currency = new Currency;
            $url = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=3';
            $xml = new SimpleXMLElement($url, NULL, true);

            $eur = (array) $xml->row[0]->exchangerate['sale'];
            $rur = (array) $xml->row[1]->exchangerate['sale'];
            $usd = (array) $xml->row[2]->exchangerate['sale'];

            $currency->uan = 1;
            $currency->eur = $eur[0];
            $currency->rur = $rur[0];
            $currency->usd = $usd[0];

            $currency->date = 86400 * ceil(time() / 86400);
            if ($currency->save()) {
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Shows if exchange rates in DB are actual
     *
     * @return bool
     */
    public static function currentExchangeRates()
    {
        if (self::getExchangeRates() == null) {
            if (!self::exchangeRates()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getExchangeRates() 
    {
        if (self::exchangeRates()) {
            $currency = Currency::find()->where(['>', 'date', time()])->orderBy(['date' => SORT_DESC])->asArray()->one();
            array_shift($currency);
            return $currency;
        }
        
        return Yii::$app->session->setFlash('warning', 'Exchange rates might differ from actual ones');
    }
}
