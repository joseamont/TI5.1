<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsuarioCal;

/**
 * UsuarioCalSearch represents the model behind the search form of `app\models\UsuarioCal`.
 */
class UsuarioCalSearch extends UsuarioCal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario', 'id_calificaciones'], 'integer'],
            [['fecha_insercion'], 'safe'],
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
        $query = UsuarioCal::find();

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
            'id_usuario' => $this->id_usuario,
            'id_calificaciones' => $this->id_calificaciones,
            'fecha_insercion' => $this->fecha_insercion,
        ]);

        return $dataProvider;
    }
}
