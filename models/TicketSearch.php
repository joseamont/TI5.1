<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ticket;

/**
 * TicketSearch represents the model behind the search form of `app\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario', 'id_suscripcion', 'id_calificacion'], 'integer'],
            [['tipo', 'fecha_apertura', 'fecha_cierre', 'status', 'descripcion'], 'safe'],
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
   // En tu modelo TicketSearch
public function search($params, $query = null)
{
    // Si no se pasa un query, usamos el default
    $query = $query ?: Ticket::find();

    // Crear el data provider con el query filtrado
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 25,
        ],
    ]);

    // Cargar los parámetros de búsqueda
    $this->load($params);

    // Aplicar filtros adicionales si es necesario
    // $query->andFilterWhere(['status' => $this->status]); // Agregar más filtros aquí si es necesario

    return $dataProvider;
}


    
}
