<?php

use app\models\Asistencia;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\AsistenciaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('asistencia')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$form = '';
$primaryColor = '#0C4B54';
$primaryLight = '#1a6d7a';
$primaryLighter = '#e6f0f1';

$this->title = 'Registro de Asistencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asistencia-index">
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: <?= $primaryColor ?>;">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-white"><?= Html::encode($this->title) ?></h3>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-striped'],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
                        'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
                        'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
                        'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
                        'options' => ['class' => 'pagination justify-content-center'],
                        'linkOptions' => ['class' => 'page-link'],
                        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled'],
                    ],
                    'layout' => "{items}\n<div class='row'><div class='col-md-6'>{summary}</div><div class='col-md-6'>{pager}</div></div>",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => '#'],
                        [
                            'attribute' => 'id_usuario',
                            'label' => 'Usuario',
                            'format' => 'raw',
                            'value' => function ($model) use ($primaryColor) {
                                $nombreUsuario = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario';
                                if (Permiso::accion('asistencia', 'view')) {
                                    return Html::a(
                                        '<i class="bi bi-person-circle me-1"></i> ' . $nombreUsuario,
                                        ['view', 'id' => $model->id],
                                        ['class' => 'btn btn-link text-decoration-none', 'style' => "color: $primaryColor;"]
                                    );
                                }
                                return $nombreUsuario;
                            }
                        ],
                        [
                            'attribute' => 'fecha',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->fecha, 'php:d/m/Y');
                            }
                        ],
                        [
                            'attribute' => 'hora_entrada',
                            'label' => 'Entrada',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                            'value' => function ($model) {
                                return $model->hora_entrada ? Yii::$app->formatter->asTime($model->hora_entrada, 'php:H:i') : '-';
                            }
                        ],
                        [
                            'attribute' => 'hora_salida',
                            'label' => 'Salida',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                            'value' => function ($model) {
                                return $model->hora_salida ? Yii::$app->formatter->asTime($model->hora_salida, 'php:H:i') : '-';
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar asistencia -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $primaryColor ?>;">
                <h5 class="modal-title text-white" id="modalFormLabel">
                    <i class="bi bi-calendar-plus me-2"></i>Registrar Asistencia
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="modalFormBody">
                    <?= $form; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </button>
                <button type="submit" form="asistencia-form" class="btn text-white" style="background-color: <?= $primaryColor ?>;">
                    <i class="bi bi-save me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<?php
// Estilos CSS adicionales
$this->registerCss(<<<CSS
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .modal-content {
        border-radius: 10px;
    }
    tr:hover {
        background-color: {$primaryLighter} !important;
    }
CSS);
?>