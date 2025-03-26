<?php

use app\models\UsuarioTic;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

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

            [
                'attribute' => 'id_usuario',
                'label' => 'Nombre de Usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $nombreUsuario = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario'; 
                    
                    /** Verificar permiso */
                    if (Permiso::accion('user', 'view')) {
                        return Html::a(
                            $nombreUsuario,
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm']
                        );
                    }
            
                    return $nombreUsuario;
                }
            ],
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
