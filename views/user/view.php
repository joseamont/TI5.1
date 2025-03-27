<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use app\models\User;
use app\models\Permiso;

if (!Permiso::seccion('user')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$form = '';
$primaryColor = '#0C4B54';
$primaryLight = '#1a6d7a';
$primaryLighter = '#e6f0f1';

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Detalles del Usuario: ' . $model->getNombreUsuario();
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: <?= $primaryColor ?>;">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-white"><?= Html::encode($this->title) ?></h3>
                <div>
                    <?php if (Permiso::accion('user', 'update')): ?>
                        <?= Html::a('<i class="bi bi-pencil-square"></i> Editar', ['#'], [
                            'class' => 'btn btn-light btn-sm me-1',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#modalForm',
                        ]) ?>
                        <?php $form = $this->render('_form', ['model' => $model, 'accion' => 'update']); ?>
                    <?php endif; ?>
                    
                    <?php if (Permiso::accion('user', 'delete')): ?>
                        <?= Html::a('<i class="bi bi-trash"></i> Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Está seguro que desea eliminar al usuario: ' . $model->getNombreUsuario() . '?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                'attributes' => [
                    [
                        'attribute' => 'Rol',
                        'format' => 'raw',
                        'value' => function ($model) use ($primaryLight) {
                            $rol = $model->rol->getNombreEstatus();
                            if (Permiso::accion('rol', 'view')) {
                                $rol = Html::a(
                                    '<i class="bi bi-shield-lock me-1"></i> ' . $model->rol->getNombreEstatus(),
                                    ['/rol/view', 'id' => $model->id_rol],
                                    [
                                        'class' => 'btn btn-link text-decoration-none',
                                        'style' => 'color: ' . $primaryLight . ';'
                                    ]
                                );
                            }
                            return $rol;
                        }
                    ],
                    [
                        'attribute' => 'username',
                        'label' => 'Correo electrónico',
                        'contentOptions' => ['class' => 'text-muted'],
                    ],
                    [
                        'attribute' => 'Estatus',
                        'format' => 'raw',
                        'value' => function ($model) use ($primaryColor) {
                            return Html::tag('span', $model->estatus ? 'Activo' : 'Inactivo', [
                                'class' => 'badge',
                                'style' => $model->estatus ? 'background-color: ' . $primaryColor . ';' : 'background-color: #6c757d;'
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'Privilegios asignados',
                        'format' => 'raw',
                        'value' => function ($model) use ($primaryColor) {
                            $arrayPrivilegios = array_filter($model->rol->privilegios, function($privilegio) {
                                return $privilegio->estatus;
                            });
                            
                            return GridView::widget([
                                'dataProvider' => new ArrayDataProvider([
                                    'allModels' => $arrayPrivilegios,
                                    'pagination' => ['pageSize' => 25]
                                ]),
                                'tableOptions' => ['class' => 'table table-hover mt-3'],
                                'pager' => [
                                    'class' => \yii\bootstrap5\LinkPager::class,
                                    'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
                                    'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
                                    'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
                                    'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
                                    'options' => ['class' => 'pagination justify-content-center'],
                                    'linkOptions' => ['class' => 'page-link'],
                                ],
                                'layout' => "{items}\n{pager}",
                                'showHeader' => false,
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'py-3'],
                                        'value' => function ($model) use ($primaryColor) {
                                            $seccion = '<span style="color: ' . $primaryColor . '; font-weight: 600;">' . 
                                                      $model->seccion->getNombreEstatus() . '</span>';
                                            
                                            $accion = $model->accion ? 
                                                ' - <span class="text-muted">' . $model->accion->getNombreEstatus() . '</span>' : '';
                                            
                                            return '<div class="d-flex align-items-center">' .
                                                   '<i class="bi bi-check-circle-fill me-2" style="color: ' . $primaryColor . ';"></i>' .
                                                   '<div>' . $seccion . $accion . '</div>' .
                                                   '</div>';
                                        }
                                    ],
                                ]
                            ]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $primaryColor ?>;">
                <h5 class="modal-title text-white" id="modalFormLabel">
                    <i class="bi bi-person-gear me-2"></i>Editar Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="modalFormBody">
                    <?= $form; ?>
                </div>
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
    .detail-view th {
        width: 25%;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }
    .detail-view td {
        vertical-align: middle;
        background-color: white;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .modal-content {
        border-radius: 10px;
    }
    .table-hover tbody tr:hover {
        background-color: {$primaryLighter} !important;
    }
CSS);
?>