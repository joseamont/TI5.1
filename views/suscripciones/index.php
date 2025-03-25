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

<div class="row">
    <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://cdn.forbes.com.mx/2022/05/Servicios-de-streaming.jpg" class="card-img-top" alt="Imagen del Plan">
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $nombrePlan = $model->nombre ? $model->nombre : 'Sin nombre';
                        
                        // Verificar permiso
                        if (Permiso::accion('suscripciones', 'view')) {
                            echo Html::a($nombrePlan, ['suscripciones/view', 'id' => $model->id], ['class' => 'text-dark']);
                        } else {
                            echo $nombrePlan;
                        }
                        ?>
                    </h5>
                    <p class="card-text">
                        <strong>Precio:</strong> <?= $model->precio ?> <br>
                        <strong>Resolución:</strong> <?= $model->resolucion ?> <br>
                        <strong>Dispositivos:</strong> <?= $model->dispositivos ?> <br>
                    </p>
                    <div class="d-flex justify-content-between">
                        <?php if (Yii::$app->user->identity->id_rol == 4): ?>
                            <?= Html::a(
                                'Contratar',
                                ['suscripciones/contratar', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quieres contratar este plan?',
                                        'method' => 'post',
                                    ],
                                ]
                            ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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