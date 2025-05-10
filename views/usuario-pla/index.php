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

// Calcular el total de los precios de los planes
$totalPlanes = 0;
$planesContratados = 0;
foreach ($dataProvider->getModels() as $model) {
    if ($model->suscripcion) {
        $totalPlanes += $model->suscripcion->precio;
        $planesContratados++;
    }
}
?>

<div class="usuario-pla-index">


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-credit-card me-2"></i><?= Html::encode($this->title) ?>
        </h1>
        <?php if (Yii::$app->user->id == 4): ?>
            <div class="bg-primary text-white p-3 rounded shadow" style="background-color: #0C4B54!important;">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-calculator me-2"></i>Total Administrador: 
                    <?= Yii::$app->formatter->asCurrency($totalPlanes) ?>
                </h4>
            </div>
        <?php endif; ?>
    </div>

<!-- Sección de totales -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #0C4B54; border-radius: 10px;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold" style="color: #0C4B54;">
                            <i class="bi bi-graph-up me-2"></i>Resumen Financiero
                        </h5>
                        <p class="mb-0 text-muted small">Total acumulado de todos los planes contratados</p>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-0 fw-bold" style="color: #0C4B54;">
                            $<?= number_format($totalPlanes, 2, '.', ',') ?> MXN
                        </h3>
                        <p class="mb-0 text-muted small">
                            <?= $planesContratados ?> <?= $planesContratados === 1 ? 'plan contratado' : 'planes contratados' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <?php foreach ($dataProvider->getModels() as $index => $model): 
            $colorIndex = $index % count($cardColors);
            $cardColor = $cardColors[$colorIndex];
        ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="border-radius: 15px; border-top: 5px solid #0C4B54; background-color: <?= $cardColor ?>;">
                <div class="card-header bg-transparent border-0 pb-0" style="border-top-left-radius: 15px!important; border-top-right-radius: 15px!important;">
                    <div class="d-flex flex-column">
                        <h3 class="mb-1 fw-bold text-center" style="color: #0C4B54;">
                            <?= $model->suscripcion ? $model->suscripcion->nombre : 'Sin plan' ?>
                        </h3>
                        <h6 class="mb-0 text-muted text-center">
                            <i class="bi bi-person-circle me-1"></i><?= $model->user ? $model->user->getNombreUsuario() : 'Sin usuario' ?>
                        </h6>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><i class="bi bi-calendar-event me-1"></i>Contratación:</span>
                        <span class="fw-bold" style="color: #0C4B54;"><?= Yii::$app->formatter->asDatetime($model->fecha_insercion) ?></span>
                    </div>
                    <?php if ($model->suscripcion): ?>
    <div class="d-flex justify-content-between align-items-center mt-2">
        <span class="text-muted"><i class="bi bi-cash-coin me-1"></i>Precio:</span>
        <span class="fw-bold" style="color: #0C4B54;">
            $<?= number_format($model->suscripcion->precio, 2, '.', ',') ?> MXN
        </span>
    </div>
<?php endif; ?>
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
    
    /* Estilo para el resumen financiero */
    .resumen-card {
        background: linear-gradient(135deg, rgba(12, 75, 84, 0.05) 0%, rgba(255,255,255,1) 100%);
        border: none;
    }
</style>