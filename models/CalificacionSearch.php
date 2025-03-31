<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calificacion;

/**
 * CalificacionSearch represents the model behind the search form of `app\models\Calificacion`.
 */
class CalificacionSearch extends Calificacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_ticket', 'id_usuario', 'rapidez', 'claridad', 'amabilidad', 'puntuacion'], 'integer'],
            [['comentario', 'fecha'], 'safe'],
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
        $query = Calificacion::find();

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
            'rapidez' => $this->rapidez,
            'claridad' => $this->claridad,
            'amabilidad' => $this->amabilidad,
            'puntuacion' => $this->puntuacion,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'comentario', $this->comentario]);

        return $dataProvider;
    }
}
