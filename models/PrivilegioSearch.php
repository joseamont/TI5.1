<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Privilegio;

/**
 * PrivilegioSearch represents the model behind the search form of `app\models\Privilegio`.
 */
class PrivilegioSearch extends Privilegio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_rol', 'id_seccion', 'id_accion'], 'integer'],
            [['estatus'], 'safe'],
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
        $query = Privilegio::find();

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
            'id_rol' => $this->id_rol,
            'id_seccion' => $this->id_seccion,
            'id_accion' => $this->id_accion,
        ]);

        $query->andFilterWhere(['like', 'estatus', $this->estatus]);

        return $dataProvider;
    }
}
