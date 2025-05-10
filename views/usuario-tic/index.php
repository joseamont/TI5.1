<?php
use app\models\UsuarioTic;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;
use app\models\Ticket;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\UsuarioTicSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tickets Asignados';
$this->params['breadcrumbs'][] = $this->title;

// Preparar datos para los filtros
$usuarios = [];
$estados = [];
foreach ($dataProvider->getModels() as $model) {
    if ($model->ticket && $model->ticket->usuario) {
        $usuarios[$model->ticket->usuario->id] = $model->ticket->usuario->getNombreUsuario();
    }
    if ($model->ticket) {
        $estados[$model->ticket->status] = $model->ticket->status;
    }
}
?>

<div class="usuario-tic-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-ticket-detailed me-2"></i><?= Html::encode($this->title) ?>
        </h1>
    </div>

    <!-- Panel de Filtros -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header" style="background-color: #0C4B54; color: white;">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="filtro-usuario" class="form-label">Usuario que levantó el ticket</label>
                    <select id="filtro-usuario" class="form-select">
                        <option value="">Todos los usuarios</option>
                        <?php foreach ($usuarios as $id => $nombre): ?>
                            <option value="<?= Html::encode($id) ?>"><?= Html::encode($nombre) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtro-estado" class="form-label">Estado del ticket</label>
                    <select id="filtro-estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= Html::encode($estado) ?>"><?= Html::encode($estado) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtro-busqueda" class="form-label">Búsqueda por ID</label>
                    <input type="text" id="filtro-busqueda" class="form-control" placeholder="Buscar por ID de ticket...">
                </div>
                <div class="col-12 text-end">
                    <button id="reset-filtros" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor de tickets -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="tickets-container">
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <div class="col ticket-item" 
                 data-usuario="<?= $model->ticket && $model->ticket->usuario ? $model->ticket->usuario->id : '' ?>"
                 data-estado="<?= $model->ticket ? Html::encode($model->ticket->status) : '' ?>"
                 data-id="<?= $model->id_ticket ?>">
                <div class="card ticket-card h-100 border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background-color: #f8f9fa; border-bottom: 2px solid #0C4B54;">
                        <span class="badge bg-primary">Ticket #<?= $model->id_ticket ?></span>
                        <span class="text-muted">Asignado</span>
                    </div>

                    <div class="card-body">
                        <div class="ticket-meta mb-3">
                            <!-- Mostrar quién levantó el ticket (usuario) -->
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-person-circle me-2" style="color: #0C4B54;"></i>
                                <div>
                                    <small class="text-muted">Usuario que levantó el ticket</small>
                                    <h6 class="mb-0">
                                        <?php if ($model->ticket && $model->ticket->usuario): ?>
                                            <?= Html::encode($model->ticket->usuario->getNombreUsuario()) ?>
                                        <?php else: ?>
                                            Sin usuario asignado
                                        <?php endif; ?>
                                    </h6>
                                </div>
                            </div>

                            <?php if (Yii::$app->user->identity->id_rol != 3): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-person-circle me-2" style="color: #0C4B54;"></i>
                                    <div>
                                        <small class="text-muted">Operador Asignado</small>
                                        <h6 class="mb-0">
                                            <?php if (Permiso::accion('user', 'view')): ?>
                                                <?= Html::a(
                                                    $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario',
                                                    ['view', 'id' => $model->id],
                                                    ['class' => 'text-decoration-none', 'style' => 'color: #0C4B54;']
                                                ) ?>
                                            <?php else: ?>
                                                <?= $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario' ?>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Mostrar fecha de asignación -->
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-calendar me-2" style="color: #0C4B54;"></i>
                                <div>
                                    <small class="text-muted">Fecha de Asignación</small>
                                    <h6 class="mb-0">
                                        <?= Yii::$app->formatter->asDatetime($model->fecha_insercion) ?>
                                    </h6>
                                </div>
                            </div>

                            <!-- Mostrar el status del ticket -->
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-circle me-2" style="color: #0C4B54;"></i>
                                <div>
                                    <small class="text-muted">Estado del Ticket</small>
                                    <h6 class="mb-0">
                                        <?= Html::encode($model->ticket->status) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0 text-center">
                        <?= Html::a(
                            '<i class="bi bi-eye-fill me-2"></i>Ver Respuesta',
                            ['ticket/ver-respuesta', 'id' => $model->id_ticket],
                            ['class' => 'btn btn-info']
                        ) ?>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center">
                        <?php if (Yii::$app->user->identity->id_rol == 1): ?>
                            <?= Html::a(
                                '<i class="bi bi-person-plus me-2"></i>Re-Asignar',
                                ['update', 'id' => $model->id],
                                ['class' => 'btn btn-sm', 'style' => 'background-color: #0C4B54; color: white;']
                            ) ?>
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
            'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i> Inicio',
            'lastPageLabel' => 'Último <i class="bi bi-chevron-double-right"></i>',
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
        ]); ?>
    </div>
</div>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<!-- Script para los filtros -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const filtroUsuario = document.getElementById('filtro-usuario');
    const filtroEstado = document.getElementById('filtro-estado');
    const filtroBusqueda = document.getElementById('filtro-busqueda');
    const resetFiltros = document.getElementById('reset-filtros');
    const ticketItems = document.querySelectorAll('.ticket-item');

    // Función para aplicar los filtros
    function aplicarFiltros() {
        const usuarioSeleccionado = filtroUsuario.value;
        const estadoSeleccionado = filtroEstado.value;
        const textoBusqueda = filtroBusqueda.value.toLowerCase();

        ticketItems.forEach(item => {
            const itemUsuario = item.getAttribute('data-usuario');
            const itemEstado = item.getAttribute('data-estado');
            const itemId = item.getAttribute('data-id');

            // Verificar si el item cumple con los filtros
            const cumpleUsuario = !usuarioSeleccionado || itemUsuario === usuarioSeleccionado;
            const cumpleEstado = !estadoSeleccionado || itemEstado === estadoSeleccionado;
            const cumpleBusqueda = !textoBusqueda || itemId.includes(textoBusqueda);

            // Mostrar u ocultar según los filtros
            if (cumpleUsuario && cumpleEstado && cumpleBusqueda) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Event listeners para los filtros
    filtroUsuario.addEventListener('change', aplicarFiltros);
    filtroEstado.addEventListener('change', aplicarFiltros);
    filtroBusqueda.addEventListener('input', aplicarFiltros);

    // Resetear filtros
    resetFiltros.addEventListener('click', function() {
        filtroUsuario.value = '';
        filtroEstado.value = '';
        filtroBusqueda.value = '';
        aplicarFiltros();
    });

    // Aplicar filtros iniciales si hay parámetros en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('TicketSearch[id_usuario]')) {
        filtroUsuario.value = urlParams.get('TicketSearch[id_usuario]');
    }
    if (urlParams.has('TicketSearch[status]')) {
        filtroEstado.value = urlParams.get('TicketSearch[status]');
    }
    if (filtroUsuario.value || filtroEstado.value) {
        aplicarFiltros();
    }
});
</script>

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

    .bg-primary {
        background-color: #0C4B54 !important;
    }

    .btn-info {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
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

    /* Estilos para el panel de filtros */
    .card-header {
        font-weight: 600;
    }
</style>