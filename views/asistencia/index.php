<?php
use app\models\Asistencia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AsistenciaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registro de Asistencias';
$this->params['breadcrumbs'][] = $this->title;

// Get unique values for filters from the existing data provider
$nombres = array_unique($dataProvider->getModels() ? array_column($dataProvider->getModels(), 'nombre_completo') : []);
$statuses = array_unique($dataProvider->getModels() ? array_column($dataProvider->getModels(), 'STATUS') : []);
$estatuses = array_unique($dataProvider->getModels() ? array_column($dataProvider->getModels(), 'estatus') : []);
?>

<div class="asistencia-index">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <!-- Filter Panel - Added this new section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header" style="background-color: #0C4B54; color: white;">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="filtro-nombre" class="form-label">Nombre</label>
                    <select id="filtro-nombre" class="form-select">
                        <option value="">Todos los nombres</option>
                        <?php foreach($nombres as $nombre): ?>
                            <option value="<?= Html::encode($nombre) ?>"><?= Html::encode($nombre) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtro-status" class="form-label">Estado</label>
                    <select id="filtro-status" class="form-select">
                        <option value="">Todos los estados</option>
                        <?php foreach($statuses as $status): ?>
                            <option value="<?= Html::encode($status) ?>"><?= Html::encode($status) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtro-estatus" class="form-label">Puntualidad</label>
                    <select id="filtro-estatus" class="form-select">
                        <option value="">Todas</option>
                        <?php foreach($estatuses as $estatus): ?>
                            <option value="<?= Html::encode($estatus) ?>"><?= Html::encode($estatus) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button id="reset-filtros" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Original GridView with added ID for JavaScript targeting -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-hover table-bordered', 'id' => 'asistencias-table'],
        'rowOptions' => function ($model, $key, $index, $grid) {
            $class = '';
            if ($model->estatus == 'Retardo') {
                $class = 'table-danger'; // Rojo para retardos
            } elseif ($model->STATUS == 'Ausente') {
                $class = 'table-warning'; // Amarillo para ausentes
            } elseif ($model->STATUS == 'Presente') {
                $class = 'table-success'; // Verde para presentes
            }
            return [
                'class' => $class,
                'data-nombre' => $model->nombre_completo,
                'data-status' => $model->STATUS,
                'data-estatus' => $model->estatus
            ];
        },
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
            'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
            'options' => ['class' => 'pagination justify-content-center mt-3'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled'],
        ],
        'layout' => "<div class='table-responsive'>{items}</div>\n<div class='row mt-3'><div class='col-md-6'>{summary}</div><div class='col-md-6 text-end'>{pager}</div></div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 
             'header' => '#',
             'headerOptions' => ['style' => 'width: 50px;', 'class' => 'text-center'],
             'contentOptions' => ['class' => 'text-center']
            ],

            [
                'attribute' => 'nombre_completo',
                'label' => 'Nombre del Usuario',
                'headerOptions' => ['class' => 'text-center'],
            ],

            [
                'attribute' => 'fecha',
                'format' => ['date', 'php:d/m/Y'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            
            [
                'attribute' => 'hora_inicio',
                'label' => 'Hora Esperada',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            
            [
                'attribute' => 'hora_entrada',
                'label' => 'Hora Registrada',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            
            [
                'attribute' => 'STATUS',
                'label' => 'Estado',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Html::tag('span', $model->STATUS, [
                        'class' => 'badge ' . ($model->STATUS == 'Presente' ? 'bg-success' : 
                                          ($model->STATUS == 'Ausente' ? 'bg-warning text-dark' : 'bg-secondary'))
                    ]);
                },
                'format' => 'raw',
            ],
            
            [
                'attribute' => 'estatus',
                'label' => 'Puntualidad',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Html::tag('span', $model->estatus, [
                        'class' => 'badge ' . ($model->estatus == 'A tiempo' ? 'bg-success' : 'bg-danger')
                    ]);
                },
                'format' => 'raw',
            ],
        ],
    ]); ?>

</div>

<!-- JavaScript for filters - Added this new section -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtroNombre = document.getElementById('filtro-nombre');
    const filtroStatus = document.getElementById('filtro-status');
    const filtroEstatus = document.getElementById('filtro-estatus');
    const resetFiltros = document.getElementById('reset-filtros');
    const tableRows = document.querySelectorAll('#asistencias-table tbody tr');

    function aplicarFiltros() {
        const nombre = filtroNombre.value.toLowerCase();
        const status = filtroStatus.value;
        const estatus = filtroEstatus.value;

        tableRows.forEach(row => {
            const rowNombre = row.getAttribute('data-nombre').toLowerCase();
            const rowStatus = row.getAttribute('data-status');
            const rowEstatus = row.getAttribute('data-estatus');

            const nombreMatch = !nombre || rowNombre.includes(nombre);
            const statusMatch = !status || rowStatus === status;
            const estatusMatch = !estatus || rowEstatus === estatus;

            if (nombreMatch && statusMatch && estatusMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    filtroNombre.addEventListener('input', aplicarFiltros);
    filtroStatus.addEventListener('change', aplicarFiltros);
    filtroEstatus.addEventListener('change', aplicarFiltros);

    resetFiltros.addEventListener('click', function() {
        filtroNombre.value = '';
        filtroStatus.value = '';
        filtroEstatus.value = '';
        aplicarFiltros();
    });
});
</script>

<!-- Original styles plus some additions for filters -->
<style>
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
        font-weight: 600;
    }
    /* Added styles for filter panel */
    .card-header {
        font-weight: 600;
    }
    .form-select {
        font-size: 0.9rem;
    }
</style>