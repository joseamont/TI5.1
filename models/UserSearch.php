<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_persona', 'id_rol'], 'integer'],
            [['username', 'password', 'authKey', 'accessToken', 'estatus'], 'safe'],
            [['nombre', 'apellidoPaterno', 'apellidoMaterno'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = User::find()
        ->joinWith('persona', 'user.id_persona = persona.id')
        ->select(['user.id', 'user.id_persona', 'user.id_rol', 'user.username', 'user.password', 'user.estatus', 
        'persona.id as id_persona', 'persona.nombre as nombre','persona.apellido_paterno', 'persona.apellido_materno']);

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
            'id_persona' => $this->id_persona,
            'id_rol' => $this->id_rol,
        ]);

        if(!isset($params['UserSearch'])){
            $params['UserSearch']['apellidoMaterno'] ='';
            $params['UserSearch']['apellidoPaterno'] ='';
            $params['UserSearch']['nombre']='';
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'estatus', $this->estatus])
            ->andFilterWhere(['like', 'nombre', $params['UserSearch']['nombre']])
            ->andFilterWhere(['like', 'apellido_paterno', $params['UserSearch']['apellidoPaterno']])
            ->andFilterWhere(['like', 'apellido_materno', $params['UserSearch']['apellidoMaterno']]);
        return $dataProvider;
    }
}
