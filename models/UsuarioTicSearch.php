<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsuarioTic;
use yii\db\ActiveQuery;

/**
 * UsuarioTicSearch represents the model behind the search form of `app\models\UsuarioTic`.
 */
class UsuarioTicSearch extends UsuarioTic
{
    public $username; // Campo adicional para el nombre de usuario
    public $status;   // Campo adicional para el status del ticket

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario', 'id_ticket'], 'integer'],
            [['fecha_insercion', 'username', 'status'], 'safe'], // Añadimos username y status a las reglas
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
        // Creamos el query para UsuarioTic, con join para User (usuario) y Ticket (status)
        $query = UsuarioTic::find()->joinWith(['user', 'ticket']); // Assuming you have these relations defined in your models

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Cargamos los parámetros de búsqueda
        $this->load($params);

        // Validamos los datos
        if (!$this->validate()) {
            return $dataProvider; // Si la validación falla, regresamos el dataProvider vacío
        }

        // Añadimos los filtros de búsqueda
        $query->andFilterWhere([
            'usuario_tic.id' => $this->id,
            'usuario_tic.id_usuario' => $this->id_usuario,
            'usuario_tic.id_ticket' => $this->id_ticket,
            'usuario_tic.fecha_insercion' => $this->fecha_insercion,
        ]);

        // Filtro por nombre de usuario (relación con User)
        if ($this->username) {
            $query->andFilterWhere(['like', 'user.username', $this->username]);
        }

        // Filtro por el estado del ticket (relación con Ticket)
        if ($this->status) {
            $query->andFilterWhere(['like', 'ticket.status', $this->status]);
        }

        return $dataProvider;
    }
}
