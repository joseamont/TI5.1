<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('user')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$form = '';

$this->title = 'Gestión de Usuarios';
$this->params['breadcrumbs'][] = $this->title;

// Definir la paleta de colores basada en el color primario #0C4B54
$primaryColor = '#0C4B54';
$primaryLight = '#1a6d7a';
$primaryLighter = '#e6f0f1';
?>
<div class="user-index">
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: <?= $primaryColor ?>;">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-white"><?= Html::encode($this->title) ?></h3>
                <?php if (Permiso::accion('user', 'create')): ?>
                    <?= Html::a('<i class="bi bi-plus-circle"></i> Nuevo usuario', ['#'], [
                        'class' => 'btn btn-light btn-sm',
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#modalForm',
                    ]) ?>
                    <?php $form = $this->render('_form', ['model' => new User(), 'accion' => 'create']); ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card-body">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
            
            <div class="table-responsive mt-4">
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
                            'attribute' => 'Nombre del usuario',
                            'format' => 'raw',
                            'value' => function ($model) use ($primaryColor) {
                                $user = $model->getNombreUsuarioEstatus();
                                if (Permiso::accion('user', 'view')) {
                                    $user = Html::a(
                                        '<i class="bi bi-person-circle me-1"></i> ' . $model->getNombreUsuarioEstatus(),
                                        ['view', 'id' => $model->id],
                                        [
                                            'class' => 'btn btn-link text-decoration-none',
                                            'style' => 'color: ' . $primaryColor . ';'
                                        ]
                                    );
                                }
                                return $user;
                            }
                        ],
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
                            'headerOptions' => ['class' => 'text-muted'],
                        ],
                        [
                            'attribute' => 'Estatus',
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                            'value' => function ($model) use ($primaryColor) {
                                if (Permiso::accion('user', 'update-estatus')) {
                                    return Html::beginForm(['update-estatus', 'id' => $model->id], 'post', ['class' => 'd-inline'])
                                        . Html::hiddenInput('User[estatus]', $model->estatus ? 0 : 1)
                                        . Html::submitButton(
                                            $model->estatus ? '<i class="bi bi-toggle-on me-1"></i> Deshabilitar' : '<i class="bi bi-toggle-off me-1"></i> Habilitar',
                                            [
                                                'class' => 'btn btn-sm',
                                                'style' => $model->estatus ? 'background-color: #dc3545; color: white;' : 'background-color: ' . $primaryColor . '; color: white;',
                                                'title' => $model->estatus ? 'Desactivar usuario' : 'Activar usuario'
                                            ]
                                        )
                                        . Html::endForm();
                                }
                                return Html::tag('span', $model->estatus ? 'Activo' : 'Inactivo', [
                                    'class' => 'badge',
                                    'style' => $model->estatus ? 'background-color: ' . $primaryColor . ';' : 'background-color: #6c757d;'
                                ]);
                            }
                        ],
                       
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear nuevo usuario -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $primaryColor ?>;">
                <h5 class="modal-title text-white" id="modalFormLabel">
                    <i class="bi bi-person-plus me-2"></i>Nuevo Usuario
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
    :root {
        --primary-color: {$primaryColor};
        --primary-light: {$primaryLight};
        --primary-lighter: {$primaryLighter};
    }
    
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
        background-color: var(--primary-lighter) !important;
    }
    .bg-primary-custom {
        background-color: var(--primary-color) !important;
    }
    .text-primary-custom {
        color: var(--primary-color) !important;
    }
    .border-primary-custom {
        border-color: var(--primary-color) !important;
    }
CSS);
?>