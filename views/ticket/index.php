<?php

use app\models\Ticket;
use app\models\respuesta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\TicketSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
if (!Permiso::seccion('ticket')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ticket-index">
    <h3> <?= Html::encode($this->title) ?> </h3>
    <hr>

    <?php
    /** Verificar permiso */
    if (Permiso::accion('ticket', 'create')) {

        //  Crear un nuevo rol utilizando _form.php en el modal 'modalForm' de abajo
        echo Html::a('Nuevo ticket', ['#'], [
            'class' => 'btn  btn-sm btn-outline-success',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalForm',
        ]);
        
        $form = $this->render('_form', ['model' => new Ticket(), 'accion' => 'create']);
    }
    ?>


<br><br>

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
                    $username = $model->user ? $model->user->username : 'Sin usuario'; 
                    
                    /** Verificar permiso */
                    if (Permiso::accion('ticket', 'view')) {
                        return Html::a(
                            $username,
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm']
                        );
                    }
            
                    return $username;
                }
            ],
            
            
            // Boton nombre suscripcion 
            [
                'attribute' => 'id_suscripcion',
                'label' => 'Nombre de la Suscripción',
                'format' => 'raw',
                'value' => function ($model) {
                    $nombreSuscripcion = $model->suscripcion ? $model->suscripcion->nombre : 'Sin suscripción'; 
                    
                    /** Verificar permiso */
                    if ($model->suscripcion && Permiso::accion('suscripcion', 'view')) {
                        return Html::a(
                            $nombreSuscripcion,
                            ['suscripcion/view', 'id' => $model->id_suscripcion],
                            ['class' => 'btn btn-outline-primary btn-sm']
                        );
                    }
            
                    return $nombreSuscripcion;
                }
            ],
            
                       
            'tipo',
            'fecha_apertura',
            'descripcion',
            [
                'attribute' => 'status',
                'label' => 'Estado',
                'format' => 'raw',
                'value' => function ($model) {
                    $statusLabel = $model->status == 'cerrado' ? 'Cerrado' : 'Sin Abrir';
                    $btnClass = $model->status == 'cerrado' ? 'secondary' : 'warning';
            
                    /** Verificar permiso y permitir cerrar si no está cerrado */
                    if ($model->status != 'cerrado' && Permiso::accion('ticket', 'update')) {
                        return Html::a(
                            $statusLabel,
                            ['ticket/cerrar', 'id' => $model->id], // Llamada a la acción para cerrar
                            [
                                'class' => "btn btn-$btnClass btn-sm",
                                'data' => [
                                    'confirm' => '¿Estás seguro de que quieres cerrar este ticket?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    }
            
                    return Html::tag('span', $statusLabel, ['class' => "badge bg-$btnClass"]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalle}', // Solo dejamos este botón personalizado
                'buttons' => [
                    'detalle' => function ($url, $model) {
                        // Verificar si el usuario tiene id_rol != 3
                        if (Yii::$app->user->identity->id_rol != 3) {
                            return Html::a(
                                'Ver Respuesta', 
                                ['ticket/ver-respuesta', 'id' => $model->id], // Llama a la nueva acción
                                [
                                    'class' => 'btn btn-info btn-sm',
                                ]
                            );
                        }
                        // Si el usuario tiene id_rol = 3, no mostrar el botón
                        return '';
                    },
                ],
            ],
                 
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{tomar}', // Solo mostramos el botón "Tomar"
                'buttons' => [
                    'tomar' => function ($url, $model) {
                        // Verificar si el usuario tiene id_rol = 3
                        if (Yii::$app->user->identity->id_rol == 3) {
                            return Html::a(
                                'Tomar Ticket',
                                ['ticket/tomar', 'id' => $model->id], // Redirige a la acción 'tomar' del TicketController
                                [
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quieres tomar este ticket?',
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        }
                        return ''; // Si el usuario no tiene rol 3, no se muestra el botón
                    },
                ],
            ],
            
            
            //Boton habilitar
        ],
    ]); ?>


</div>

<!-- Modal donde se presenta _form para crear un nuevo rol  -->
<div class="modal fade modal-lg" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Nuevo Ticket
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal-body">
                <div id="modalFormBody">
                    <?= $form; ?>
                </div>
            </div>
        </div>
    </div>
</div>