<?php
use app\models\Horario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\HorarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\UsuarioHor $usuarioHorModel */

if (!Permiso::seccion('horario')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$this->title = 'Gestión de Horarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horario-index">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold" style="color: #0C4B54;">
                <i class="bi bi-clock-history me-2"></i><?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Administración de horarios laborales y especiales</p>
        </div>
        
    </div>

    <div class="row g-4">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 border-0 card-horario" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h5 mb-0 fw-bold" style="color: #0C4B54;">
                            <?= Html::encode($model->dias) ?>
                        </h3>
                        <span class="badge <?= $model->tipo == 'Laboral' ? 'bg-primary' : 'bg-success' ?> badge-horario">
                            <?= Html::encode($model->tipo) ?>
                        </span>
                    </div>
                </div>

                <div class="card-body pt-2 pb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-clock-fill me-2" style="color: #0C4B54; font-size: 1.2rem;"></i>
                        <div>
                            <small class="text-muted d-block">Hora inicio</small>
                            <span class="time-display"><?= Yii::$app->formatter->asTime($model->hora_inicio) ?></span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-clock-fill me-2" style="color: #0C4B54; font-size: 1.2rem;"></i>
                        <div>
                            <small class="text-muted d-block">Hora fin</small>
                            <span class="time-display"><?= Yii::$app->formatter->asTime($model->hora_fin) ?></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between pt-2 border-top">
                        <?php if (Permiso::accion('usuario_hor', 'update')): ?>
                            <?= Html::a('<i class="bi bi-people-fill me-1"></i> Asignar', ['#'], [
                                'class' => 'btn btn-sm btn-primary rounded-pill px-3',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#assignModal'.$model->id,
                            ]) ?>
                        <?php endif; ?>

                        <?php if (Permiso::accion('horario', 'update')): ?>
                        <?= Html::a(
                            '<i class="bi bi-eye-fill me-1"></i> Actualizar Horario', 
                            ['update', 'id' => $model->id],
                            ['class' => 'btn btn-sm btn-info']
                        ) ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

       <!-- Modal de Asignación para cada horario -->
<div class="modal fade modal-assign" id="assignModal<?= $model->id ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: #0C4B54; color: white;">
                <h5 class="modal-title">
                    <i class="bi bi-people-fill me-2"></i>Asignar Horario: <?= Html::encode($model->dias) ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php $form = \yii\widgets\ActiveForm::begin([
                    'action' => ['usuario-hor/assign'],
                    'method' => 'post',
                    'id' => 'assign-form-'.$model->id
                ]); ?>

                <?= $form->field($usuarioHorModel, 'id_usuario')->dropDownList(
                    \yii\helpers\ArrayHelper::map(
                        User::find()
                            ->where(['id_rol' => 3]) // Solo empleados rol 3
                            ->andWhere(['NOT IN', 'id', 
                                (new \yii\db\Query())
                                    ->select('id_usuario')
                                    ->from('usuario_hor') // Usuarios ya asignados
                            ])
                            ->orderBy('username') // Ordenado por nombre
                            ->all(),
                        'id',
                        'username'
                    ),
                    [
                        'prompt' => 'Seleccionar empleado',
                        'class' => 'form-select'
                    ]
                )->label('Empleado') ?>

                <?= $form->field($usuarioHorModel, 'id_horario')->hiddenInput(['value' => $model->id])->label(false) ?>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i> Horario: <?= Yii::$app->formatter->asTime($model->hora_inicio) ?> - <?= Yii::$app->formatter->asTime($model->hora_fin) ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-primary rounded-pill px-3">
                    <i class="bi bi-save me-1"></i> Guardar Asignación
                </button>
            </div>

                <?php \yii\widgets\ActiveForm::end(); ?>

        </div>
    </div>
</div>

        <?php endforeach; ?>
    </div>

    <!-- Paginación Mejorada -->
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <div class="text-muted">
            Mostrando <?= $dataProvider->getCount() ?> de <?= $dataProvider->getTotalCount() ?> horarios
        </div>
        <?= \yii\bootstrap5\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination mb-0'],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
            'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
            'maxButtonCount' => 5,
            'disableCurrentPageButton' => true
        ]) ?>
    </div>
</div>

<!-- Modal para crear nuevo horario -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: #0C4B54; color: white;">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Horario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form', ['model' => new Horario(), 'accion' => 'create']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .card-horario {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-left: 4px solid #0C4B54;
    }
    
    .card-horario:hover {
        box-shadow: 0 4px 8px rgba(12, 75, 84, 0.1);
        border-left-color: #1a6d7a;
    }
    
    .badge-horario {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 0.35rem 0.7rem;
    }
    
    .time-display {
        font-size: 1.1rem;
        font-weight: 500;
        color: #0C4B54;
    }
    
    .modal-assign {
        max-width: 450px;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(12, 75, 84, 0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(12, 75, 84, 0.1) !important;
    }
    
    .btn-primary {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-primary:hover {
        background-color: #0A3A42;
        border-color: #0A3A42;
    }
    
    .btn-outline-primary {
        color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-outline-primary:hover {
        background-color: #0C4B54;
        color: white;
    }
    
    .bg-primary {
        background-color: #0C4B54 !important;
    }
    
    .rounded-pill {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .form-select, .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #0C4B54;
        box-shadow: 0 0 0 0.25rem rgba(12, 75, 84, 0.25);
    }
    
    .page-item.active .page-link {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .page-link {
        color: #0C4B54;
    }
</style>