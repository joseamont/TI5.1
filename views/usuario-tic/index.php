<?php

use app\models\UsuarioTic;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsuarioTicSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tickets asignados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-tic-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        /** dataProvider poblado desde TicketController - actionIndex() */
        'dataProvider' => $dataProvider,
        /** Formado de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_usuario',
            'id_ticket',
            'fecha_insercion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalle}', // Solo dejamos este botón personalizado
                'buttons' => [
                    'detalle' => function ($url, $model) {
                        return Html::a(
                            'Ver Respuesta', 
                            ['ticket/ver-respuesta', 'id' => $model->id], // Llama a la nueva acción
                            [
                                'class' => 'btn btn-info btn-sm',
                            ]
                        );
                    },
                ],
            ], 
        ],
    ]); ?>


</div>
