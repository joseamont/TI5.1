<?php
use app\models\UsuarioPla;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\UsuarioPlaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('usuario_pla')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Gestión de Planes de Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-pla-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-credit-card me-2"></i><?= Html::encode($this->title) ?>
        </h1>
        
        <?php if (Permiso::accion('usuario_pla', 'create')): ?>
            <?= Html::a('<i class="bi bi-plus-circle me-2"></i>Nuevo Plan Cliente', ['#'], [
                'class' => 'btn btn-primary',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalForm',
            ]) ?>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover mb-0'],
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
                    'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
                    'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
                    'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
                    'options' => ['class' => 'pagination justify-content-center mt-3'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
                ],
                'layout' => "{items}\n{pager}",
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => '#',
                        'headerOptions' => ['style' => 'width: 50px;'],
                    ],
                    [
                        'attribute' => 'id_usuario',
                        'label' => 'Usuario',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // Usamos la función getNombreUsuario() para obtener el nombre completo del usuario
                            $nombreUsuario = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario';
                            $btnClass = Permiso::accion('usuario_pla', 'view') ? 'btn btn-sm btn-outline-primary' : '';
                    
                            return Permiso::accion('usuario_pla', 'view') 
                                ? Html::a($nombreUsuario, ['view', 'id' => $model->id], ['class' => $btnClass])
                                : $nombreUsuario;
                        }
                    ],
                    
                    [
                        'attribute' => 'id_suscripcion',
                        'label' => 'Plan',
                        'format' => 'raw',
                        'value' => function($model) {
                            // Asumiendo que tienes una relación 'suscripcion' en tu modelo
                            $plan = $model->suscripcion ? $model->suscripcion->nombre : 'Sin plan';
                            return Html::tag('span', $plan, ['class' => 'badge bg-info text-dark']);
                        }
                    ],
                    [
                        'attribute' => 'fecha_insercion',
                        'label' => 'Fecha Contratacion',
                        'format' => 'datetime',
                        'headerOptions' => ['style' => 'width: 180px;'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<!-- Modal para crear nuevo plan cliente -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalFormLabel">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Plan Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form', ['model' => new UsuarioPla(), 'accion' => 'create']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #0C4B54;
        font-weight: 600;
        border-top: none;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-primary {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-primary:hover {
        background-color: #0A3A42;
        border-color: #0A3A42;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
    }
    
    .bg-info {
        background-color: #E8F549!important;
        color: #0C4B54!important;
    }
    
    .btn-outline-primary {
        color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-outline-primary:hover {
        background-color: #0C4B54;
        color: white;
    }
</style>