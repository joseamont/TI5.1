<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\UsuarioPla $model */

if (!Permiso::seccion('usuario_pla')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$this->title = 'Detalle de Plan Contratado';
$this->params['breadcrumbs'][] = ['label' => 'Gestión de Planes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="usuario-pla-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-card-checklist me-2"></i><?= Html::encode($this->title) ?>
        </h1>
        <?php if (Permiso::accion('usuario_pla', 'delete')): ?>
            <?= Html::a('<i class="bi bi-trash me-1"></i> Eliminar', '#', [
                'class' => 'btn btn-sm btn-danger',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalMensaje',
                'onClick' => "
                    $('#ModalLabelMensaje').text('Cancelar suscripción');
                    $('#ModalBodyMensaje').html('¿Confirmar que desea cancelar la suscripción: <b>" . Html::encode($model->suscripcion->nombre) . "</b>?<br><small class=\"text-muted\">Si tiene usuarios o privilegios asignados primero deberá quitar las asignaciones.</small>');
                    $('#ModalButtonMensaje').attr('data-url', '" . Yii::$app->urlManager->createUrl(['usuario-pla/delete', 'id' => $model->id]) . "');
                ",
            ]) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->identity->id_rol == 4): ?>
        <p>Para cancelar servicio levante un ticket</p>
        <?php endif; ?>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="ModalLabelMensaje" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: #0C4B54; color: white;">
                    <h5 class="modal-title" id="ModalLabelMensaje"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="ModalBodyMensaje"></div>
                <div class="modal-footer">
                    <?= Html::beginForm('', 'post', ['id' => 'deleteForm']) ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger" id="ModalButtonMensaje" data-url="">
                            <i class="bi bi-check-circle me-1"></i>Confirmar
                        </button>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4" style="border-left: 4px solid #0C4B54;">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                    <h5 class="card-title mb-0 fw-bold" style="color: #0C4B54;">
                        <i class="bi bi-info-circle me-2"></i>Información del Plan
                    </h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped detail-view'],
                        'attributes' => [
                            [
                                'attribute' => 'id_usuario',
                                'label' => 'Usuario',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->usuario 
                                        ? Html::tag('span', $model->usuario->getNombreUsuario(), ['class' => 'badge', 'style' => 'background-color: #0C4B54; color: white;'])
                                        : 'Sin usuario';
                                },
                            ],
                            [
                                'attribute' => 'id_suscripcion',
                                'label' => 'Suscripción',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->suscripcion 
                                        ? Html::tag('span', $model->suscripcion->nombre, ['class' => 'badge', 'style' => 'background-color: #E8F549; color: #0C4B54;'])
                                        : 'Sin suscripción';
                                },
                            ],
                            [
                                'attribute' => 'fecha_insercion',
                                'label' => 'Fecha de Contratación',
                                'format' => 'datetime',
                                'contentOptions' => ['class' => 'text-muted'],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm" style="border-left: 4px solid #0C4B54;">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <h5 class="card-title mb-0 fw-bold" style="color: #0C4B54;">
                <i class="bi bi-list-ul me-2"></i>Otras Suscripciones del Usuario
            </h5>
        </div>
        <div class="card-body">
            <?php
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => \app\models\UsuarioPla::find()
                    ->where(['id_usuario' => $model->id_usuario])
                    ->andWhere(['!=', 'id', $model->id]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover mb-0'],
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'header' => '#'],
                    [
                        'attribute' => 'id_usuario',
                        'label' => 'Usuario',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->usuario 
                                ? Html::tag('span', $model->usuario->getNombreUsuario(), ['class' => 'badge', 'style' => 'background-color: #0C4B54; color: white;'])
                                : 'Sin usuario';
                        },
                    ],
                    [
                        'attribute' => 'id_suscripcion',
                        'label' => 'Suscripción',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->suscripcion 
                                ? Html::tag('span', $model->suscripcion->nombre, ['class' => 'badge', 'style' => 'background-color: #E8F549; color: #0C4B54;'])
                                : 'Sin suscripción';
                        },
                    ],
                    [
                        'attribute' => 'fecha_insercion',
                        'label' => 'Fecha',
                        'format' => 'datetime',
                        'contentOptions' => ['class' => 'text-muted'],
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
                        'visible' => Permiso::accion('usuario_pla', 'view'),
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
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
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

<script>
    // Actualizar la URL del formulario cuando se haga clic en el botón de confirmación
    $('#ModalButtonMensaje').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        $('#deleteForm').attr('action', url);
        $('#deleteForm').submit();
    });
</script>
<?php
$script = <<< JS
$(document).ready(function () {
    $('#ModalButtonMensaje').on('click', function (e) {
        e.preventDefault(); // Evita la recarga de la página
        let url = $(this).attr('data-url'); // Obtiene la URL del botón
        $('#deleteForm').attr('action', url); // Asigna la URL al formulario
        $('#deleteForm').submit(); // Envía el formulario
    });
});
JS;
$this->registerJs($script);
?>
