<?php
use app\models\UsuarioTic;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;
use app\models\Ticket;

/** @var yii\web\View $this */
/** @var app\models\UsuarioTicSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tickets Asignados';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuario-tic-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-ticket-detailed me-2"></i><?= Html::encode($this->title) ?>
        </h1>
    </div>



    <div class="row g-4">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card ticket-card h-100 border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 2px solid #0C4B54;">
                    <span class="badge bg-primary">Ticket #<?= $model->id_ticket ?></span>
                    <span class="text-muted">Asignado</span>
                </div>
                
                <div class="card-body">
                    <div class="ticket-meta mb-3">
                        <!-- Mostrar quién levantó el ticket (usuario) -->
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-person-circle me-2" style="color: #0C4B54;"></i>
                            <div>
                                <small class="text-muted">Usuario que levantó el ticket</small>
                                <h6 class="mb-0">
                                    <?php if ($model->ticket && $model->ticket->usuario) : ?>
                                        <?= Html::encode($model->ticket->usuario->getNombreUsuario()) ?>
                                    <?php else: ?>
                                        Sin usuario asignado
                                    <?php endif; ?>
                                </h6>
                            </div>
                        </div>

                        <?php if (Yii::$app->user->identity->id_rol != 3): ?>
    <div class="d-flex align-items-center mb-3">
        <i class="bi bi-person-circle me-2" style="color: #0C4B54;"></i>
        <div>
            <small class="text-muted">Operador Asignado</small>
            <h6 class="mb-0">
                <?php if (Permiso::accion('user', 'view')): ?>
                    <?= Html::a(
                        $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario',
                        ['view', 'id' => $model->id],
                        ['class' => 'text-decoration-none', 'style' => 'color: #0C4B54;']
                    ) ?>
                <?php else: ?>
                    <?= $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario' ?>
                <?php endif; ?>
            </h6>
        </div>
    </div>
<?php endif; ?>



                        <!-- Mostrar fecha de asignación -->
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-calendar me-2" style="color: #0C4B54;"></i>
                            <div>
                                <small class="text-muted">Fecha de Asignación</small>
                                <h6 class="mb-0">
                                    <?= Yii::$app->formatter->asDatetime($model->fecha_insercion) ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Mostrar el status del ticket -->
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-circle me-2" style="color: #0C4B54;"></i>
                            <div>
                                <small class="text-muted">Estado del Ticket</small>
                                <h6 class="mb-0">
                                    <?= Html::encode($model->ticket->status) ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-0 text-center">
                    <?= Html::a(
                        '<i class="bi bi-eye-fill me-2"></i>Ver Respuesta', 
                        ['ticket/ver-respuesta', 'id' => $model->id_ticket], // Asegurar que se usa el ID correcto
                        ['class' => 'btn btn-info']
                    ) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        <?= \yii\bootstrap5\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i> Inicio',
            'lastPageLabel' => 'Último <i class="bi bi-chevron-double-right"></i>',
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
        ]); ?>
    </div>
</div>


<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .ticket-card {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid rgba(12, 75, 84, 0.1);
    }
    
    .ticket-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(12, 75, 84, 0.15);
        border-color: rgba(12, 75, 84, 0.3);
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .bg-primary {
        background-color: #0C4B54!important;
    }
    
    .btn-info {
        background-color: #17a2b8!important;
        border-color: #17a2b8!important;
    }
    
    .page-link {
        color: #0C4B54;
    }
    
    .page-item.active .page-link {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .ticket-meta h6 {
        font-size: 0.95rem;
        font-weight: 500;
    }
</style>