<?php

use app\models\Suscripciones;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\SuscripcionesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('suscripciones')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Planes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suscripciones-index">

<h3> <?= Html::encode($this->title) ?> </h3>
    <hr>

    <?php
    /** Verificar permiso */
    if (Permiso::accion('suscripciones', 'create')) {

        //  Crear un nuevo rol utilizando _form.php en el modal 'modalForm' de abajo
        echo Html::a('Nuevo plan', ['#'], [
            'class' => 'btn  btn-sm btn-outline-success',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalForm',
        ]);
        
        $form = $this->render('_form', ['model' => new Suscripciones(), 'accion' => 'create']);
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

            'id',
            [
                'attribute' => 'nombre',
                'label' => 'Nombre del Plan',
                'format' => 'raw',
                'value' => function ($model) {
                    $nombrePlan = $model->nombre ? $model->nombre : 'Sin nombre';
            
                    /** Verificar permiso */
                    if (Permiso::accion('suscripciones', 'view')) {
                        return Html::a(
                            $nombrePlan,
                            ['suscripciones/view', 'id' => $model->id], // Redirige al view del plan
                            ['class' => 'btn btn-outline-dark btn-sm']
                        );
                    }
            
                    return $nombrePlan;
                }
            ],
            
            'nombre',
            'precio',
            'resolucion',
            'dispositivos',
            //'duracion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{contratar}', // Eliminamos los otros botones
                'buttons' => [
                    'contratar' => function ($url, $model) {
                        if (Yii::$app->user->identity->id_rol == 4) {
                            return Html::a(
                                'Contratar', 
                                ['suscripciones/contratar', 'id' => $model->id], // Asegurar que coincide con el controlador correcto
                                [
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quieres contratar este plan?',
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        }
                        return '';
                    },
                ],
            ],
            
            
            
        ],
    ]); ?>


</div>

<!-- Modal donde se presenta _form para crear un nuevo rol  -->
<div class="modal fade modal-lg" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Nuevo Plan
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