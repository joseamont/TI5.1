<?php

use app\models\Ticket;
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
                    if (Permiso::accion('ticket', 'view')) {
                        return Html::a(
                            $nombreSuscripcion,
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-primary btn-sm']
                        );
                    }
            
                    return $nombreSuscripcion;
                }
            ],
                       
            'tipo',
            'fecha_apertura',
            'descripcion',
            'status'
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