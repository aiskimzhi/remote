<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bookmark;

/**
 * BookmarkSearch represents the model behind the search form about `app\models\Bookmark`.
 */
class BookmarkSearch extends Bookmark
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'advert_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Bookmark::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'advert_id' => $this->advert_id,
        ]);

        return $dataProvider;
    }

    /**
     * Selects adverts added to bookmarks by a certain user
     * 
     * @return ActiveDataProvider
     */
    public function getMyBookmarks()
    {
        $query = Bookmark::find()->andFilterWhere([
            'user_id' => Yii::$app->user->identity->getId(),
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
}
