<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Respuesta;

/**
 * RespuestaSearch represents the model behind the search form of `app\models\Respuesta`.
 */
class RespuestaSearch extends Respuesta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_ticket', 'id_usuario'], 'integer'],
            [['respuesta', 'fecha'], 'safe'],
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
        $query = Respuesta::find();

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
            'id_ticket' => $this->id_ticket,
            'id_usuario' => $this->id_usuario,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'respuesta', $this->respuesta]);

        return $dataProvider;
    }
}
