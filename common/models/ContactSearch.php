<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contact;
use common\models\User;

/**
 * NewrubricaSearch represents the model behind the search form about `\common\models\Newrubrica`.
 */
class ContactSearch extends Contact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contact_category_id'], 'integer'],
            [['gruppi'], 'safe'],
            [['firstname', 'lastname', 'email', 'company' , 'phone_prefix', 'phone', 'mobile_prefix', 'mobile', 'general_prefix', 'general'], 'safe'],
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
        $query = User::readFilter(Contact::find()->joinWith('contact_groups'));
        //$query = Yii::$app->user->identity->readFilter(Contact::find()->joinWith('contact_groups'));
                                    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'phone_prefix', $this->phone_prefix])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mobile_prefix', $this->mobile_prefix])
            ->andFilterWhere(['like', 'general_prefix', $this->general_prefix])
            ->andFilterWhere(['like', 'general', $this->general])            
            ->andFilterWhere(['=', 'contact_category_id', $this->contact_category_id]);

        return $dataProvider;
    }
}
