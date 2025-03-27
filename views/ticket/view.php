<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Ticket;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\Ticket $model */

$this->title = 'Ticket #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ticket-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-ticket-detailed me-2"></i><?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="card shadow-sm mb-4" style="border-left: 4px solid #0C4B54;">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <h5 class="card-title mb-0 fw-bold" style="color: #0C4B54;">
                <i class="bi bi-info-circle me-2"></i>Detalles del Ticket
            </h5>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped detail-view'],
                'attributes' => [
                    [
                        'attribute' => 'id_usuario',
                        'label' => 'Nombre de Usuario',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $nombreUsuario = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario';
                            return Html::tag('span', $nombreUsuario, ['class' => 'badge', 'style' => 'background-color: #0C4B54; color: white;']);
                        }
                    ],
                    [
                        'attribute' => 'id_suscripcion',
                        'label' => 'Nombre del Plan',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $nombrePlan = $model->suscripcion ? $model->suscripcion->nombre : 'Sin suscripción';
                            
                            if ($model->suscripcion && Permiso::accion('suscripciones', 'view')) {
                                return Html::a(
                                    $nombrePlan,
                                    ['suscripciones/view', 'id' => $model->id_suscripcion],
                                    ['class' => 'btn btn-sm', 'style' => 'background-color: #E8F549; color: #0C4B54;']
                                );
                            }
                            
                            return Html::tag('span', $nombrePlan, ['class' => 'badge', 'style' => 'background-color: #E8F549; color: #0C4B54;']);
                        }
                    ],
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::tag('span', $model->tipo, ['class' => 'badge bg-primary']);
                        }
                    ],
                    'fecha_apertura',
                    'fecha_cierre',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                            $statusClass = $model->status == 'Abierto' ? 'bg-success' : 'bg-secondary';
                            return Html::tag('span', $model->status, ['class' => 'badge '.$statusClass]);
                        }
                    ],
                    'descripcion:ntext',
                    'id_calificacion',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card shadow-sm" style="border-left: 4px solid #0C4B54;">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <h5 class="card-title mb-0 fw-bold" style="color: #0C4B54;">
                <i class="bi bi-list-ul me-2"></i>Otros Tickets del Usuario
            </h5>
        </div>
        <div class="card-body">
            <?php
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => Ticket::find()->where(['id_usuario' => $model->id_usuario])->andWhere(['!=', 'id', $model->id]),
                'pagination' => ['pageSize' => 5],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover mb-0'],
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'header' => '#'],
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::tag('span', $model->tipo, ['class' => 'badge bg-primary']);
                        }
                    ],
                    'fecha_apertura',
                    'fecha_cierre',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                            $statusClass = $model->status == 'Abierto' ? 'bg-success' : 'bg-secondary';
                            return Html::tag('span', $model->status, ['class' => 'badge '.$statusClass]);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Acciones',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                    'class' => 'btn btn-sm',
                                    'style' => 'background-color: #0C4B54; color: white;',
                                    'title' => 'Ver detalles'
                                ]);
                            },
                        ],
                        'visible' => Permiso::accion('ticket', 'view'),
                    ],
                ],
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
                    'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
                    'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
                    'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
                    'options' => ['class' => 'pagination justify-content-center mt-3'],
                    'linkOptions' => ['class' => 'page-link'],
                ],
            ]) ?>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .card {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #0C4B54;
        font-weight: 600;
        border-top: none;
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    .bg-success {
        background-color: #28a745!important;
    }
    
    .bg-primary {
        background-color: #0C4B54!important;
    }
    
    .detail-view tr:last-child td {
        border-bottom: none;
    }
    
    .page-link {
        color: #0C4B54;
    }
    
    .page-item.active .page-link {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
</style>