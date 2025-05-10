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

$this->title = 'Planes de Suscripción';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suscripciones-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="row g-4">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 subscription-card shadow-sm border-0 overflow-hidden">
                <div class="card-header position-relative p-0" style="height: 180px; overflow: hidden;">
                    <img src="https://images.unsplash.com/photo-1605106702734-205df224ecce?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                         class="card-img-top w-100 h-100 object-fit-cover" 
                         alt="Imagen del Plan">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>
                    <div class="position-absolute bottom-0 start-0 p-3 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                        <h3 class="card-title text-white mb-0">
                            <?php if (Permiso::accion('suscripciones', 'view')): ?>
                                <?= Html::a($model->nombre ?: 'Sin nombre', 
                                    ['suscripciones/view', 'id' => $model->id], 
                                    ['class' => 'text-white text-decoration-none stretched-link']) ?>
                            <?php else: ?>
                                <span class="text-white"><?= $model->nombre ?: 'Sin nombre' ?></span>
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            <span class="h5 mb-0">$<?= number_format($model->precio, 2) ?></span>
                            <span class="small">/mes</span>
                        </span>
                        
                        <?php if (Yii::$app->user->identity->id_rol == 4): ?>
                            <?= Html::a(
                                'Contratar <i class="bi bi-arrow-right ms-1"></i>',
                                ['suscripciones/contratar', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quieres contratar este plan?',
                                        'method' => 'post',
                                    ],
                                ]
                            ) ?>
                        <?php endif; ?>
                    </div>
                    
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2">
                            <i class="bi bi-display text-primary me-2"></i>
                            <strong>Resolución:</strong> <?= $model->resolucion ?>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-phone text-primary me-2"></i>
                            <strong>Dispositivos:</strong> <?= $model->dispositivos ?>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-primary me-2"></i>
                            <strong>Calidad:</strong> <?= $model->resolucion ?: 'HD' ?>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalFormLabel">
                        <i class="bi bi-plus-circle me-2"></i>Nuevo Plan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <?= $this->render('_form', ['model' => new Suscripciones(), 'accion' => 'create']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .subscription-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid rgba(12, 75, 84, 0.1);
    }
    
    .subscription-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(12, 75, 84, 0.1);
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-footer {
        padding: 0 1.5rem 1.5rem;
    }
    
    .badge.bg-primary {
        background-color: #0C4B54 !important;
    }
    
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        border-radius: 8px;
        padding: 0.375rem 1rem;
        font-weight: 500;
    }
    
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    
    .btn-primary {
        background-color: #0C4B54;
        border-color: #0C4B54;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
    }
    
    .btn-primary:hover {
        background-color: #0A3A42;
        border-color: #0A3A42;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .modal-header {
        border-radius: 12px 12px 0 0;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">