<?php
use app\models\Calificacion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\CalificacionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Calificaciones';
$this->params['breadcrumbs'][] = $this->title;

// Registrar Bootstrap Icons
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css');

// Prepare data for filters
$operators = ArrayHelper::map(
    User::find()->where(['id_rol' => 3])->all(),
    'id',
    function($model) { return $model->getNombreUsuario(); }
);

$clients = ArrayHelper::map(
    User::find()->where(['id_rol' => 4])->all(),
    'id',
    function($model) { return $model->getNombreUsuario(); }
);

$ticketTypes = ArrayHelper::map(
    \app\models\Ticket::find()->select('tipo')->distinct()->all(),
    'tipo',
    'tipo'
);
?>

<div class="calificacion-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-star-fill me-2"></i><?= Html::encode($this->title) ?>
        </h1>
    </div>

    <!-- Filter Panel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background-color: #0C4B54; color: white;">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="js-filter-type" class="form-label">Tipo de Ticket</label>
                    <select id="js-filter-type" class="form-select">
                        <option value="">Todos</option>
                        <?php foreach($ticketTypes as $type): ?>
                            <option value="<?= Html::encode($type) ?>"><?= Html::encode($type) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="js-filter-operator" class="form-label">Operador</label>
                    <select id="js-filter-operator" class="form-select">
                        <option value="">Todos</option>
                        <?php foreach($operators as $id => $name): ?>
                            <option value="<?= $id ?>"><?= Html::encode($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="js-filter-client" class="form-label">Cliente</label>
                    <select id="js-filter-client" class="form-select">
                        <option value="">Todos</option>
                        <?php foreach($clients as $id => $name): ?>
                            <option value="<?= $id ?>"><?= Html::encode($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="js-filter-rating" class="form-label">Puntuación</label>
                    <select id="js-filter-rating" class="form-select">
                        <option value="">Todas</option>
                        <option value="1">1 Estrella</option>
                        <option value="2">2 Estrellas</option>
                        <option value="3">3 Estrellas</option>
                        <option value="4">4 Estrellas</option>
                        <option value="5">5 Estrellas</option>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button id="js-reset-filters" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th style="min-width: 120px;">Tipo de Ticket</th>
                            <th style="min-width: 150px;">Operador</th>
                            <th style="min-width: 150px;">Cliente</th>
                            <th style="width: 100px;">Rapidez</th>
                            <th style="width: 100px;">Claridad</th>
                            <th style="width: 100px;">Amabilidad</th>
                            <th style="width: 120px;">Puntuación</th>
                            <th style="width: 120px;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="js-ratings-container">
                        <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                        <tr class="js-rating-row" 
                            data-type="<?= $model->ticket ? Html::encode($model->ticket->tipo) : '' ?>"
                            data-operator="<?= $model->getIdUsuarioFromUsuarioTic() ?>"
                            data-client="<?= $model->usuario ? $model->usuario->id : '' ?>"
                            data-rapidez="<?= $model->rapidez ?>"
                            data-claridad="<?= $model->claridad ?>"
                            data-amabilidad="<?= $model->amabilidad ?>"
                            data-rating="<?= $model->puntuacion ?>">
                            <td><?= $index + 1 ?></td>
                            <td>
                                <?= $model->ticket ? Html::tag('span', $model->ticket->tipo, [
                                    'class' => 'badge bg-info text-dark'
                                ]) : 'Sin tipo' ?>
                            </td>
                            <td>
                                <?= Html::tag('div', $model->getIdUsuarioFromUsuarioTic(), ['class' => 'fw-semibold']) ?>
                            </td>
                            <td>
                                <?= Html::tag('div', $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario', ['class' => 'fw-semibold']) ?>
                            </td>
                            <td>
                                <?= Html::tag('span', $model->rapidez, [
                                    'class' => 'badge ' . ($model->rapidez >= 4 ? 'bg-success' : ($model->rapidez >= 3 ? 'bg-warning' : 'bg-danger'))
                                ]) ?>
                            </td>
                            <td>
                                <?= Html::tag('span', $model->claridad, [
                                    'class' => 'badge ' . ($model->claridad >= 4 ? 'bg-success' : ($model->claridad >= 3 ? 'bg-warning' : 'bg-danger'))
                                ]) ?>
                            </td>
                            <td>
                                <?= Html::tag('span', $model->amabilidad, [
                                    'class' => 'badge ' . ($model->amabilidad >= 4 ? 'bg-success' : ($model->amabilidad >= 3 ? 'bg-warning' : 'bg-danger'))
                                ]) ?>
                            </td>
                            <td>
                                <?= str_repeat('<i class="bi bi-star-fill text-warning"></i>', $model->puntuacion) ?>
                            </td>
                            <td class="text-center">
                                <?= Html::a('<i class="bi bi-bar-chart-line-fill me-1"></i> Ver Gráficas', ['view', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-primary rounded-pill',
                                    'title' => 'Ver gráficas de calificaciones',
                                    'style' => '
                                        background: linear-gradient(135deg, #0C4B54, #1D7874);
                                        border: none;
                                        box-shadow: 0 2px 8px rgba(12, 75, 84, 0.3);
                                        transition: all 0.3s ease;
                                        padding: 0.35rem 1rem;
                                    ',
                                    'onmouseover' => 'this.style.transform="translateY(-2px)"; this.style.boxShadow="0 4px 12px rgba(12, 75, 84, 0.4)";',
                                    'onmouseout' => 'this.style.transform=""; this.style.boxShadow="0 2px 8px rgba(12, 75, 84, 0.3)";'
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get filter elements
    const typeFilter = document.getElementById('js-filter-type');
    const operatorFilter = document.getElementById('js-filter-operator');
    const clientFilter = document.getElementById('js-filter-client');
    const ratingFilter = document.getElementById('js-filter-rating');
    const resetBtn = document.getElementById('js-reset-filters');
    const ratingRows = document.querySelectorAll('.js-rating-row');

    // Apply filters function
    function applyFilters() {
        const selectedType = typeFilter.value;
        const selectedOperator = operatorFilter.value;
        const selectedClient = clientFilter.value;
        const selectedRating = ratingFilter.value;

        ratingRows.forEach(row => {
            const rowType = row.getAttribute('data-type');
            const rowOperator = row.getAttribute('data-operator');
            const rowClient = row.getAttribute('data-client');
            const rowRating = row.getAttribute('data-rating');

            // Check if row matches all selected filters
            const typeMatch = !selectedType || rowType === selectedType;
            const operatorMatch = !selectedOperator || rowOperator.includes(selectedOperator);
            const clientMatch = !selectedClient || rowClient === selectedClient;
            const ratingMatch = !selectedRating || rowRating === selectedRating;

            // Show/hide row based on matches
            if (typeMatch && operatorMatch && clientMatch && ratingMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Add event listeners
    typeFilter.addEventListener('change', applyFilters);
    operatorFilter.addEventListener('change', applyFilters);
    clientFilter.addEventListener('change', applyFilters);
    ratingFilter.addEventListener('change', applyFilters);

    // Reset filters
    resetBtn.addEventListener('click', function() {
        typeFilter.value = '';
        operatorFilter.value = '';
        clientFilter.value = '';
        ratingFilter.value = '';
        applyFilters();
    });

    // Apply initial filters from URL if present
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('CalificacionSearch[tipo]')) {
        typeFilter.value = urlParams.get('CalificacionSearch[tipo]');
    }
    if (urlParams.has('CalificacionSearch[id_usuario]')) {
        clientFilter.value = urlParams.get('CalificacionSearch[id_usuario]');
    }
    if (urlParams.has('CalificacionSearch[puntuacion]')) {
        ratingFilter.value = urlParams.get('CalificacionSearch[puntuacion]');
    }
    if (typeFilter.value || clientFilter.value || ratingFilter.value) {
        applyFilters();
    }
});
</script>

<style>
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.85em;
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }
    
    tr:hover {
        background-color: #e6f0f1 !important;
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .form-control {
        border-radius: 0.375rem;
    }
    
    .page-item.active .page-link {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .page-link {
        color: #0C4B54;
    }
    
    .fw-semibold {
        font-weight: 600;
    }
    
    .text-warning {
        color: #ffc107 !important;
    }
    
    /* Filter panel styles */
    .card-header {
        font-weight: 600;
    }
</style>