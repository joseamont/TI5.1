<?php
use app\models\Calificacion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\CalificacionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Calificaciones';
$this->params['breadcrumbs'][] = $this->title;

// Registrar Bootstrap Icons
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css');
?>
<div class="calificacion-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-star-fill me-2"></i><?= Html::encode($this->title) ?>
        </h1>
        <?= Html::a('<i class="bi bi-plus-circle me-2"></i> Crear Calificación', ['create'], [
            'class' => 'btn btn-primary',
            'style' => 'background-color: #0C4B54; border-color: #0C4B54;'
        ]) ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover align-middle'],
                'options' => ['class' => 'table-responsive'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'header' => '#', 'contentOptions' => ['style' => 'width: 50px;']],
                    
                    [
                        'attribute' => 'id_ticket',
                        'label' => 'Tipo de Ticket',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ticket ? Html::tag('span', $model->ticket->tipo, [
                                'class' => 'badge bg-info text-dark'
                            ]) : 'Sin tipo';
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(
                            \app\models\Ticket::find()->select('tipo')->distinct()->all(), 
                            'tipo', 
                            'tipo'
                        ),
                        'contentOptions' => ['style' => 'min-width: 120px;']
                    ],

                    [
                        'label' => 'Operador',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $nombre = $model->getIdUsuarioFromUsuarioTic();
                            return Html::tag('div', $nombre, ['class' => 'fw-semibold']);
                        },
                        'contentOptions' => ['style' => 'min-width: 150px;']
                    ],

                    [
                        'attribute' => 'id_usuario',
                        'label' => 'Cliente',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $nombre = $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario';
                            return Html::tag('div', $nombre, ['class' => 'fw-semibold']);
                        },
                        'contentOptions' => ['style' => 'min-width: 150px;']
                    ],

                    [
                        'attribute' => 'rapidez',
                        'content' => function($model) {
                            return Html::tag('span', $model->rapidez, [
                                'class' => 'badge ' . ($model->rapidez >= 4 ? 'bg-success' : ($model->rapidez >= 3 ? 'bg-warning' : 'bg-danger'))
                            ]);
                        },
                        'filter' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                        'contentOptions' => ['style' => 'width: 100px;']
                    ],

                    [
                        'attribute' => 'claridad',
                        'content' => function($model) {
                            return Html::tag('span', $model->claridad, [
                                'class' => 'badge ' . ($model->claridad >= 4 ? 'bg-success' : ($model->claridad >= 3 ? 'bg-warning' : 'bg-danger'))
                            ]);
                        },
                        'filter' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                        'contentOptions' => ['style' => 'width: 100px;']
                    ],

                    [
                        'attribute' => 'amabilidad',
                        'content' => function($model) {
                            return Html::tag('span', $model->amabilidad, [
                                'class' => 'badge ' . ($model->amabilidad >= 4 ? 'bg-success' : ($model->amabilidad >= 3 ? 'bg-warning' : 'bg-danger'))
                            ]);
                        },
                        'filter' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                        'contentOptions' => ['style' => 'width: 100px;']
                    ],

                    [
                        'attribute' => 'puntuacion',
                        'content' => function($model) {
                            $stars = str_repeat('<i class="bi bi-star-fill text-warning"></i>', $model->puntuacion);
                            return Html::tag('div', $stars, ['style' => 'font-size: 1.1rem;']);
                        },
                        'filter' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                        'contentOptions' => ['style' => 'width: 120px;']
                    ],

                    [
                        'attribute' => 'comentario',
                        'value' => function($model) {
                            return mb_strimwidth($model->comentario, 0, 50, '...');
                        },
                        'contentOptions' => ['style' => 'min-width: 200px;']
                    ],

                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Acciones',
                        'template' => '{view}',
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width: 120px;'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => 'Ver'
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

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
</style>