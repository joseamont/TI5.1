<?php
use app\models\UsuarioHor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\UsuarioHorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('usuario_hor')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$this->title = 'Horario Trabajador';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-hor-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #0C4B54;">
                <i class="bi bi-calendar-check me-2"></i><?= Html::encode($this->title) ?>
            </h3>
            <p class="text-muted mb-0">Asignación de horarios a trabajadores</p>
        </div>
        
        <?php if (Permiso::accion('usuario_hor', 'create')): ?>
            <?= Html::a('<i class="bi bi-plus-circle me-2"></i> Nuevo Horario Trabajador', ['#'], [
                'class' => 'btn btn-primary btn-sm',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalForm',
            ]) ?>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 border-0" style="border-radius: 12px; border-left: 4px solid #0C4B54;">
                <div class="card-header bg-transparent border-0 pt-3 pb-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="h6 mb-0 fw-bold" style="color: #0C4B54;">
                            <?= $model->user ? $model->user->username : 'Sin usuario' ?>
                        </h4>
                        <span class="badge bg-secondary rounded-pill">ID: <?= $model->id ?></span>
                    </div>
                </div>
                
                <div class="card-body pt-1 pb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-clock-history me-2" style="color: #0C4B54;"></i>
                        <div>
                            <small class="text-muted d-block">Horario ID</small>
                            <span class="fw-bold"><?= $model->id_horario ?></span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-calendar-date me-2" style="color: #0C4B54;"></i>
                        <div>
                            <small class="text-muted d-block">Fecha de asignación</small>
                            <span class="fw-bold"><?= Yii::$app->formatter->asDate($model->fecha_insercion) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                    <div class="d-flex justify-content-end">
                        <?php if (Permiso::accion('usuario_hor', 'view')): ?>
                            <?= Html::a('<i class="bi bi-eye"></i>', ['view', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-outline-primary rounded-circle me-2',
                                'title' => 'Ver detalles'
                            ]) ?>
                        <?php endif; ?>
                        
                        <?php if (Permiso::accion('usuario_hor', 'update')): ?>
                            <?= Html::a('<i class="bi bi-pencil"></i>', ['update', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-outline-secondary rounded-circle me-2',
                                'title' => 'Editar'
                            ]) ?>
                        <?php endif; ?>
                        
                        <?php if (Permiso::accion('usuario_hor', 'delete')): ?>
                            <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-outline-danger rounded-circle',
                                'title' => 'Eliminar',
                                'data' => [
                                    'confirm' => '¿Está seguro que desea eliminar esta asignación?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
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
            'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i> Inicio',
            'lastPageLabel' => 'Último <i class="bi bi-chevron-double-right"></i>',
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        ]) ?>
    </div>
</div>

<!-- Modal para crear nuevo horario trabajador -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: #0C4B54;">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Horario Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form', ['model' => new UsuarioHor(), 'accion' => 'create']) ?>
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
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(12, 75, 84, 0.1) !important;
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
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    .rounded-circle {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    @media (max-width: 768px) {
        .row.g-4 {
            row-gap: 1.5rem;
        }
    }
</style>