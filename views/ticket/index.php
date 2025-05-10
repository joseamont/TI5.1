<?php
use app\models\Ticket;
use app\models\respuesta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\UsuarioPla;
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

$this->title = 'Gestión de Tickets';
$this->params['breadcrumbs'][] = $this->title;

// Preparar datos para filtros JS
$statusOptions = [];
$tipoOptions = [];
foreach ($dataProvider->getModels() as $model) {
    $statusOptions[$model->status] = $model->status == 'cerrado' ? 'Resuelto' : ($model->status == 'abierto' ? 'En Proceso' : 'Pendiente');
    $tipoOptions[$model->tipo] = $model->tipo;
}
?>

<div class="ticket-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-ticket-detailed me-2"></i><?= Html::encode($this->title) ?>
        </h1>

        <?php if (Yii::$app->user->id == 4): ?>
            <div class="bg-primary text-white p-3 rounded shadow" style="background-color: #0C4B54!important;">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-calculator me-2"></i>Total Administrador: 
                    <?= Yii::$app->formatter->asCurrency($totalPlanes) ?>
                </h4>
            </div>
        <?php endif; ?>
        
        <?php 
        $tienePlanContratado = UsuarioPla::find()
            ->where(['id_usuario' => Yii::$app->user->id])
            ->andWhere(['not', ['id_suscripcion' => null]])
            ->exists();

        if (Permiso::accion('ticket', 'create')): ?>
            <?php if ($tienePlanContratado): ?>
                <?= Html::a('<i class="bi bi-plus-circle me-2"></i> Nuevo Ticket', ['#'], [
                    'class' => 'btn btn-success btn-lg',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modalForm',
                ]) ?>
                <?php $form = $this->render('_form', ['model' => new Ticket(), 'accion' => 'create']); ?>
            <?php else: ?>
                <div class="btn-wrapper" data-bs-toggle="tooltip" title="Necesitas tener un plan contratado para abrir tickets" data-bs-placement="bottom">
                    <?= Html::button('<i class="bi bi-plus-circle me-2"></i> Nuevo Ticket', [
                        'class' => 'btn btn-success btn-lg',
                        'disabled' => true,
                        'style' => 'pointer-events: none;'
                    ]) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Filtros JavaScript -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header" style="background-color: #0C4B54; color: white;">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="filtro-busqueda" class="form-label">Búsqueda general</label>
                    <input type="text" id="filtro-busqueda" class="form-control" placeholder="Buscar...">
                </div>
                <div class="col-md-3">
                    <label for="filtro-estado" class="form-label">Estado</label>
                    <select id="filtro-estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <?php foreach ($statusOptions as $value => $label): ?>
                            <option value="<?= Html::encode($value) ?>"><?= Html::encode($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtro-tipo" class="form-label">Tipo</label>
                    <select id="filtro-tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <?php foreach ($tipoOptions as $value): ?>
                            <option value="<?= Html::encode($value) ?>"><?= Html::encode($value) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button id="reset-filtros" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor de tickets -->
    <div id="tickets-container" class="row g-4">
        <?php foreach ($dataProvider->getModels() as $model): 
            $statusClass = $model->status == 'cerrado' ? 'bg-success' : ($model->status == 'abierto' ? 'bg-warning' : 'bg-secondary');
            $statusLabel = $model->status == 'cerrado' ? 'Resuelto' : ($model->status == 'abierto' ? 'En Proceso' : 'Pendiente');
        ?>
        <div class="col-12 col-md-6 col-lg-4 ticket-item" 
             data-status="<?= Html::encode($model->status) ?>"
             data-tipo="<?= Html::encode($model->tipo) ?>"
             data-search="<?= Html::encode(strtolower($model->tipo . ' ' . $model->descripcion . ' ' . ($model->user ? $model->user->getNombreUsuario() : '') . ' ' . ($model->suscripcion ? $model->suscripcion->nombre : ''))) ?>">
            <div class="card ticket-card h-100 border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 2px solid #0C4B54;">
                    <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                    <span class="text-muted">#<?= $model->id ?></span>
                </div>
                
                <div class="card-body">
                    <div class="ticket-meta mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-person-circle me-2" style="color: #0C4B54;"></i>
                            <div>
                                <small class="text-muted">Usuario</small>
                                <h6 class="mb-0">
                                    <?php if (Permiso::accion('ticket', 'view')): ?>
                                        <?= Html::a(
                                            $model->user ? $model->user->getNombreUsuario() : 'Sin usuario',
                                            ['view', 'id' => $model->id],
                                            ['class' => 'text-decoration-none', 'style' => 'color: #0C4B54;']
                                        ) ?>
                                    <?php else: ?>
                                        <?= $model->user ? $model->user->getNombreUsuario() : 'Sin usuario' ?>
                                    <?php endif; ?>
                                </h6>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-credit-card me-2" style="color: #0C4B54;"></i>
                            <div>
                                <small class="text-muted">Suscripción</small>
                                <h6 class="mb-0">
                                    <?php if ($model->suscripcion && Permiso::accion('suscripciones', 'view')): ?>
                                        <?= Html::a(
                                            $model->suscripcion->nombre,
                                            ['suscripciones/view', 'id' => $model->id_suscripcion],
                                            ['class' => 'text-decoration-none', 'style' => 'color: #0C4B54;']
                                        ) ?>
                                    <?php else: ?>
                                        <?= $model->suscripcion ? $model->suscripcion->nombre : 'Sin suscripción' ?>
                                    <?php endif; ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ticket-content">
                        <h5 class="card-title" style="color: #0C4B54;">
                            <i class="bi bi-tag-fill me-2"></i><?= Html::encode($model->tipo) ?>
                        </h5>
                        <div class="card-text mb-3">
                            <small class="text-muted">Descripción:</small>
                            <p class="mb-0"><?= Html::encode(mb_strimwidth($model->descripcion, 0, 100, '...')) ?></p>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block">
                                    <i class="bi bi-calendar me-1"></i> <?= Yii::$app->formatter->asDate($model->fecha_apertura) ?>
                                </small>
                                <?php if ($model->fecha_cierre): ?>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-calendar-check me-1"></i> <?= Yii::$app->formatter->asDate($model->fecha_cierre) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($model->status != 'cerrado' && Permiso::accion('ticket', 'update')): ?>
                                <?= Html::a(
                                    '<i class="bi bi-lock"></i>',
                                    ['ticket/cerrar', 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'title' => 'Cerrar ticket',
                                        'data' => [
                                            'confirm' => '¿Estás seguro de que quieres cerrar este ticket?',
                                            'method' => 'post',
                                        ],
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                    <?php if (Yii::$app->user->identity->id_rol == 4): ?>
                        <?= Html::a(
                            '<i class="bi bi-eye-fill me-1"></i> Ver Respuesta', 
                            ['ticket/ver-respuesta', 'id' => $model->id],
                            ['class' => 'btn btn-sm btn-info']
                        ) ?>
                    <?php endif; ?>
                    
                    <?php if (Yii::$app->user->identity->id_rol == 3): ?>
                        <?= Html::a(
                            '<i class="bi bi-check-circle me-1"></i> Tomar',
                            ['ticket/tomar', 'id' => $model->id],
                            [
                                'class' => 'btn btn-sm btn-success',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que quieres tomar este ticket?',
                                    'method' => 'post',
                                ],
                            ]
                        ) ?>
                    <?php endif; ?>
                    
                    <?= Html::a(
                        '<i class="bi bi-three-dots"></i> Detalles',
                        ['view', 'id' => $model->id],
                        ['class' => 'btn btn-sm', 'style' => 'background-color: #0C4B54; color: white;']
                    ) ?>
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
        ]); ?>
    </div>
</div>

<!-- Modal para crear nuevo ticket -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background-color: #0C4B54;">
                <h5 class="modal-title" id="modalFormLabel">
                    <i class="bi bi-plus-circle me-2"></i> Nuevo Ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= $form ?>
            </div>
        </div>
    </div>
</div>

<!-- Script para filtros JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Elementos del DOM
    const filtroBusqueda = document.getElementById('filtro-busqueda');
    const filtroEstado = document.getElementById('filtro-estado');
    const filtroTipo = document.getElementById('filtro-tipo');
    const resetFiltros = document.getElementById('reset-filtros');
    const ticketItems = document.querySelectorAll('.ticket-item');

    // Función para aplicar filtros
    function aplicarFiltros() {
        const textoBusqueda = filtroBusqueda.value.toLowerCase();
        const estadoSeleccionado = filtroEstado.value;
        const tipoSeleccionado = filtroTipo.value;

        ticketItems.forEach(item => {
            const itemStatus = item.getAttribute('data-status');
            const itemTipo = item.getAttribute('data-tipo');
            const itemSearch = item.getAttribute('data-search');

            // Verificar filtros
            const coincideTexto = itemSearch.includes(textoBusqueda);
            const coincideEstado = !estadoSeleccionado || itemStatus === estadoSeleccionado;
            const coincideTipo = !tipoSeleccionado || itemTipo === tipoSeleccionado;

            // Mostrar/ocultar según los filtros
            if (coincideTexto && coincideEstado && coincideTipo) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Event listeners
    filtroBusqueda.addEventListener('input', aplicarFiltros);
    filtroEstado.addEventListener('change', aplicarFiltros);
    filtroTipo.addEventListener('change', aplicarFiltros);

    // Resetear filtros
    resetFiltros.addEventListener('click', function() {
        filtroBusqueda.value = '';
        filtroEstado.value = '';
        filtroTipo.value = '';
        aplicarFiltros();
    });

    // Aplicar filtros iniciales si hay parámetros en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('TicketSearch[status]')) {
        filtroEstado.value = urlParams.get('TicketSearch[status]');
    }
    if (urlParams.has('TicketSearch[tipo]')) {
        filtroTipo.value = urlParams.get('TicketSearch[tipo]');
    }
    if (filtroEstado.value || filtroTipo.value) {
        aplicarFiltros();
    }
});
</script>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .ticket-card {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid rgba(12, 75, 84, 0.1);
    }
    
    .ticket-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(12, 75, 84, 0.15);
        border-color: rgba(12, 75, 84, 0.3);
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .bg-success {
        background-color: #28a745!important;
    }
    
    .bg-warning {
        background-color: #ffc107!important;
        color: #212529!important;
    }
    
    .bg-secondary {
        background-color: #6c757d!important;
    }
    
    .btn-success {
        background-color: #28a745!important;
        border-color: #28a745!important;
    }
    
    .btn-info {
        background-color: #17a2b8!important;
        border-color: #17a2b8!important;
    }
    
    .page-link {
        color: #0C4B54;
    }
    
    .page-item.active .page-link {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .ticket-meta h6 {
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .ticket-content .card-title {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    /* Estilos para el panel de filtros */
    .card-header {
        font-weight: 600;
    }
</style>