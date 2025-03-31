<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Calificacion $model */

$this->title = "Calificación #".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calificaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

// Registrar Chart.js
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css');
?>
<div class="calificacion-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-star-fill me-2"></i><?= Html::encode($this->title) ?>
        </h1>
        <div>
            <?= Html::a('<i class="bi bi-pencil me-2"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary me-2']) ?>
            <?= Html::a('<i class="bi bi-trash me-2"></i> Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estás seguro de eliminar esta calificación?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Detalles de la Calificación</h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id_ticket',
                                'value' => $model->ticket ? $model->ticket->tipo : 'No especificado',
                            ],
                            [
                                'attribute' => 'id_usuario',
                                'value' => $model->usuario ? $model->usuario->getNombreUsuario() : 'No especificado',
                            ],
                            [
                                'attribute' => 'fecha',
                                'format' => ['date', 'php:d/m/Y H:i:s'],
                            ],
                            [
                                'attribute' => 'comentario',
                                'format' => 'ntext',
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Puntuaciones</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <canvas id="radarChart" height="200"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <canvas id="barChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para los gráficos
    const data = {
        labels: ['Rapidez', 'Claridad', 'Amabilidad', 'Puntuación General'],
        datasets: [{
            label: 'Calificación',
            data: [<?= $model->rapidez ?>, <?= $model->claridad ?>, <?= $model->amabilidad ?>, <?= $model->puntuacion ?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configuración común
    const config = {
        scales: {
            y: {
                beginAtZero: true,
                max: 5,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    // Gráfico de radar
    new Chart(
        document.getElementById('radarChart'),
        {
            type: 'radar',
            data: data,
            options: {
                ...config,
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            }
        }
    );

    // Gráfico de barras
    new Chart(
        document.getElementById('barChart'),
        {
            type: 'bar',
            data: data,
            options: config
        }
    );
});
</script>

<style>
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        background-color: #f8f9fa;
    }
    
    .table th {
        width: 40%;
    }
    
    .btn-primary {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-primary:hover {
        background-color: #0A3A42;
        border-color: #0A3A42;
    }
    
    .fw-bold {
        color: #0C4B54;
    }
</style>