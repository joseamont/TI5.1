<?php
use app\models\Horario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\HorarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('horario')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$this->title = 'Gestión de Horarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horario-index">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold" style="color: #0C4B54;">
                <i class="bi bi-clock-history me-2"></i><?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Administración de horarios laborales y especiales</p>
        </div>
        
        <?php if (Permiso::accion('horario', 'create')): ?>
            <?= Html::a('<i class="bi bi-plus-circle me-2"></i> Crear Horario', ['#'], [
                'class' => 'btn btn-primary btn-lg shadow-sm',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalForm',
            ]) ?>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 border-0" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h5 mb-0 fw-bold" style="color: #0C4B54;">
                            <?= Html::encode($model->dias) ?>
                        </h3>
                        <span class="badge <?= $model->tipo == 'Laboral' ? 'bg-primary' : 'bg-success' ?> rounded-pill">
                            <?= Html::encode($model->tipo) ?>
                        </span>
                    </div>
                </div>
                
                <div class="card-body pt-2 pb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-clock-fill me-2" style="color: #0C4B54; font-size: 1.2rem;"></i>
                        <div>
                            <small class="text-muted d-block">Hora inicio</small>
                            <span class="fw-bold"><?= Yii::$app->formatter->asTime($model->hora_inicio) ?></span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-clock-fill me-2" style="color: #0C4B54; font-size: 1.2rem;"></i>
                        <div>
                            <small class="text-muted d-block">Hora fin</small>
                            <span class="fw-bold"><?= Yii::$app->formatter->asTime($model->hora_fin) ?></span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-2 border-top">
                        <?= Html::a('<i class="bi bi-pencil-square me-1"></i> Editar', ['update', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-outline-primary rounded-pill px-3'
                        ]) ?>
                        
                        <?= Html::a('<i class="bi bi-people-fill me-1"></i> Asignar', ['#'], [
                            'class' => 'btn btn-sm btn-primary rounded-pill px-3',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#assignModal'.$model->id,
                        ]) ?>
                        
                        <?= Html::a('<i class="bi bi-trash me-1"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-outline-danger rounded-circle',
                            'data' => [
                                'confirm' => '¿Está seguro que desea eliminar este horario?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para asignar horario -->
        <div class="modal fade" id="assignModal<?= $model->id ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header" style="background-color: #0C4B54; color: white;">
                        <h5 class="modal-title">
                            <i class="bi bi-people-fill me-2"></i>Asignar Horario
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Asignar el horario <strong><?= Html::encode($model->dias) ?></strong> a:</p>
                        <!-- Aquí iría el formulario de asignación -->
                        <div class="form-group mb-3">
                            <label class="form-label">Seleccionar empleado</label>
                            <select class="form-select">
                                <option selected>Seleccione un empleado</option>
                                <option>Empleado 1</option>
                                <option>Empleado 2</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary rounded-pill">Guardar Asignación</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        <?= \yii\bootstrap5\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
            'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        ]) ?>
    </div>
</div>

<!-- Modal para crear nuevo horario -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: #0C4B54; color: white;">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Horario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form', ['model' => new Horario(), 'accion' => 'create']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(12, 75, 84, 0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(12, 75, 84, 0.1) !important;
    }
    
    .btn-primary {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-primary:hover {
        background-color: #0A3A42;
        border-color: #0A3A42;
    }
    
    .btn-outline-primary {
        color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-outline-primary:hover {
        background-color: #0C4B54;
        color: white;
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.4em 0.8em;
        font-weight: 500;
    }
    
    .bg-primary {
        background-color: #0C4B54 !important;
    }
    
    .rounded-pill {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .form-select, .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #0C4B54;
        box-shadow: 0 0 0 0.25rem rgba(12, 75, 84, 0.25);
    }
</style>