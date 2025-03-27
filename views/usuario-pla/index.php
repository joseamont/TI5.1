<?php
use app\models\UsuarioPla;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\UsuarioPlaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('usuario_pla')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Gestión de Planes de Clientes';
$this->params['breadcrumbs'][] = $this->title;

// Colores para los cards (paleta pastel)
$cardColors = ['#E3F2FD', '#E8F5E9', '#FFF8E1', '#F3E5F5', '#FFEBEE', '#E0F7FA'];
?>

<div class="usuario-pla-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-credit-card me-2"></i><?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $index => $model): 
            $colorIndex = $index % count($cardColors);
            $cardColor = $cardColors[$colorIndex];
        ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="border-radius: 15px; border-top: 5px solid #0C4B54; background-color: <?= $cardColor ?>;">
                <div class="card-header bg-transparent border-0 pb-0" style="border-top-left-radius: 15px!important; border-top-right-radius: 15px!important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-person-circle me-2"></i><?= $model->user ? $model->user->getNombreUsuario() : 'Sin usuario' ?>
                        </h5>
                        <span class="badge rounded-pill" style="background-color: #0C4B54; color: white;">
                            <?= $model->suscripcion ? $model->suscripcion->nombre : 'Sin plan' ?>
                        </span>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><i class="bi bi-calendar-event me-1"></i>Contratación:</span>
                        <span class="fw-bold" style="color: #0C4B54;"><?= Yii::$app->formatter->asDatetime($model->fecha_insercion) ?></span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <?php if (Permiso::accion('usuario_pla', 'view')): ?>
                        <?= Html::a('<i class="bi bi-eye-fill me-1"></i> Ver detalles', ['view', 'id' => $model->id], [
                            'class' => 'btn btn-sm w-100',
                            'style' => 'background-color: #0C4B54; color: white; border-radius: 8px;'
                        ]) ?>
                    <?php endif; ?>
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
        ]); ?>
    </div>
</div>

<!-- Modal para crear nuevo plan cliente -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalFormLabel">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Plan Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form', ['model' => new UsuarioPla(), 'accion' => 'create']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .card {
        transition: all 0.3s ease;
        border-left: 4px solid #0C4B54;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(12, 75, 84, 0.2);
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    .btn-outline-primary {
        color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-outline-primary:hover {
        background-color: #0C4B54;
        color: white;
    }
    
    .text-primary {
        color: #0C4B54!important;
    }
</style>