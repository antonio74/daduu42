<?php

namespace api\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * NewrubricaSearch represents the model behind the search form about `\api\models\Newrubrica`.
 */
class ContactSearch extends \common\models\ContactSearch
{
  
    // add the public attributes that will be used to store the data to filter results
    public $category, $group;

    // add the rules to make those attributes safe
    public function rules()
    {
        $rules = parent::rules();
        $rules[]= [['category', 'group'], 'safe'];
        $rules[]= [['category', 'group'], 'trim'];
        return $rules;
    }

    /**
     * Creates data provider instance with search query applied 
     * and join with category and gruppo tables
     *  
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $expandCategoria=false; 
        $expandGruppo=false;
        $query = User::readFilter(Contact::find()->joinWith('contact_groups'));
                                    
        // Join per poter filtrare anche attraverso categoria e gruppo
        if(isset($params['expand'])){
            $expand = array_map('trim',explode(",", $params['expand']));
            foreach ($expand as $value) {
                if($value =='contact_category'){
                    $query->joinWith('contact_category');
                    $expandCategoria=true;
                }
                elseif ($value =='contact_groups'){                    
                    $query->joinWith('contact_groups');   
                    $expandGruppo=true;
                }
            }    
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])            
            ->andFilterWhere(['=', 'contact_category_id', $this->contact_category_id]);

        // Filtro e ordinamento per categoria e gruppo solo se settato anche il rispettivo valore del parametro expand
        $dataProvider->sort->enableMultiSort=true;
        if(isset($expand))
            foreach ($expand as $value) {
                if($value =='contact_category'){
                    $query->andFilterWhere(['like', 'contact_category.name', $this->category]);
                    $dataProvider->sort->attributes['category']=['asc' => ['contact_category.name' => SORT_ASC], 
                                                                    'desc' => ['contact_category.name' => SORT_DESC]];
                }
                elseif ($value =='contact_groups'){
                    $query->andFilterWhere(['like', 'contact_group.name', $this->group]);
                    $dataProvider->sort->attributes['group']=['asc' => ['contact_group.name' => SORT_ASC], 
                                                                    'desc' => ['contact_group.name' => SORT_DESC]];                    
                }           
            }

        // Ordinamento con parametro in formato json e controllo sintassi. I parametri non validi vengono ignorati
        /*if(isset($params['sort']) && $params['sort']!=null){
            $sort=$params['sort'];
            $i=0;
            $order='';
            foreach ($sort as $attribute => $orderType) {
                if(($attribute=='categoria' && $expandCategoria==true) || ($attribute=='gruppo' && $expandGruppo==true)){
                    $order=$order . $attribute . '.nome ' . $orderType;
                }
                elseif(in_array($attribute, $this->activeAttributes(), true)==true)
                    $order=$order . $attribute . ' ' . $orderType;
                $i=$i+1;
                if($i<count($sort))
                    $order=$order . ', ';
            }
            //$order="agaga" . implode(', ', Newrubrica::fields());
            $query->orderBy($order);
        }*/

        /*$s=Yii::$app->session;
        //$s->open();
        //$s->set('tenant','1');        
        $t=$s->get('tenant');
        $order="agaga" . implode(', ', $expand);
        $query->orderBy("agaga");
        $dataProvider=parent::search($params);
        $query=$dataProvider->query;
        //$query->andFilterWhere(['like', 'firstname', 'ant']);
        return $dataProvider;

        */
        return $dataProvider;
    }
}
