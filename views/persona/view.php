<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\PersonaInfo;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Persona $model */

$this->title = $model->nombre . ' ' . $model->apellido_paterno;
$this->params['breadcrumbs'][] = ['label' => 'Mi Perfil', 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="persona-view">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-sm border-0 profile-card">
            <div class="card-header py-3" style="background-color: #0C4B54; border-bottom: none;">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0 text-white">
            <i class="bi bi-person-badge me-2"></i><?= Html::encode($this->title) ?>
        </h2>
      
    </div>
</div>
                
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="avatar-container mb-3">
                                <div class="avatar-circle d-flex align-items-center justify-content-center" 
                                     style="background-color: rgba(12, 75, 84, 0.1); border: 3px solid #0C4B54;">
                                    <i class="bi bi-person-fill" style="font-size: 2.5rem; color: #0C4B54;"></i>
                                </div>
                            </div>
                            <h4 class="mb-2" style="color: #0C4B54;"><?= Html::encode($model->nombre . ' ' . $model->apellido_paterno) ?></h4>
                            <p class="text-muted mb-3"><i class="bi bi-person-lines-fill me-2"></i>Perfil de usuario</p>
                            
                            <div class="d-flex justify-content-center mt-3 pt-3 border-top">
                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 me-2">
                                    <i class="bi bi-envelope me-1"></i> Contactar
                                </button>
                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    <i class="bi bi-share me-1"></i> Compartir
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="profile-details p-3">
                            <?= DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'table table-profile mb-0'],
    'attributes' => [

        [
            'attribute' => 'nombre',
            'label' => '<i class="bi bi-person me-2"></i> Nombre',
            'format' => 'raw',
        ],
        [
            'attribute' => 'apellido_paterno',
            'label' => '<i class="bi bi-person me-2"></i> Apellido Paterno',
            'format' => 'raw',
        ],
        [
            'attribute' => 'apellido_materno',
            'label' => '<i class="bi bi-person me-2"></i> Apellido Materno',
            'format' => 'raw',
        ],
        [
            'label' => '<i class="bi bi-calendar me-2"></i> Fecha de Nacimiento',
            'value' => function($model) {
                return $model->personaInfo ? Yii::$app->formatter->asDate($model->personaInfo->fecha_nacimiento) : 'No disponible';
            },
            'format' => 'raw',
        ],
        [
            'label' => '<i class="bi bi-gender-ambiguous me-2"></i> Género',
            'value' => function($model) {
                return $model->personaInfo ? $model->personaInfo->genero : 'No disponible';
            },
            'format' => 'raw',
        ],
        [
            'label' => '<i class="bi bi-telephone me-2"></i> Teléfono',
            'value' => function($model) {
                return $model->personaInfo ? $model->personaInfo->telefono : 'No disponible';
            },
            'format' => 'raw',
        ],
        [
            'label' => '<i class="bi bi-house-door me-2"></i> Dirección',
            'value' => function($model) {
                return $model->personaInfo ? $model->personaInfo->direccion : 'No disponible';
            },
            'format' => 'raw',
        ],
        [
            'label' => '<i class="bi bi-clock-history me-2"></i> Fecha de Registro',
            'value' => function($model) {
                return $model->personaInfo ? Yii::$app->formatter->asDate($model->personaInfo->fecha_registro, 'long') : 'No disponible';
            },
            'format' => 'raw',
        ],
    ],
    'template' => '<tr><th class="w-40">{label}</th><td class="text-dark">{value}</td></tr>'
]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer py-2" style="background-color: #f8f9fa; border-top: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-clock-history me-1"></i> Última actualización: <?= date('d/m/Y H:i') ?>
                        </small>
                        <small>
                            <?= Html::a('<i class="bi bi-lock me-1"></i> Privacidad', '#', ['class' => 'text-muted']) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Persona Info -->
<div class="modal fade" id="personaInfoModal" tabindex="-1" aria-labelledby="personaInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0C4B54; color: white;">
                <h5 class="modal-title" id="personaInfoModalLabel">
                    <i class="bi bi-person-lines-fill me-2"></i>Información Personal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="personaInfoModalContent">
                <!-- El contenido se cargará dinámicamente aquí -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadPersonaInfo(idPersona) {
    // Cargar el formulario en el modal
    $('#personaInfoModalContent').load('<?= Url::to(['persona-info/form-modal']) ?>?id_persona=' + idPersona);
}

// Limpiar el modal cuando se cierre
$('#personaInfoModal').on('hidden.bs.modal', function () {
    $('#personaInfoModalContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    `);
});
</script>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .profile-card {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
        margin-top: 1.5rem;
        border: 1px solid rgba(12, 75, 84, 0.1);
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    
    .avatar-container {
        position: relative;
        margin: 0 auto;
        width: 150px;
    }
    
    .avatar-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .avatar-circle:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 15px rgba(12, 75, 84, 0.1);
    }
    
    .table-profile {
        width: 100%;
    }
    
    .table-profile th {
        font-weight: 600;
        color: #0C4B54;
        padding: 0.75rem 1rem 0.75rem 0;
        vertical-align: middle;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    
    .table-profile td {
        font-weight: 500;
        vertical-align: middle;
        font-size: 0.95rem;
        padding: 0.75rem 0;
    }
    
    .table-profile tr:not(:last-child) {
        border-bottom: 1px solid #f1f3f5;
    }
    
    .btn-light {
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    .btn-light:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .profile-details {
        background-color: #fff;
        border-radius: 8px;
    }
    
    .btn-outline-secondary {
        border-color: #dee2e6;
        color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        color: #0C4B54;
        border-color: #0C4B54;
    }
    
    @media (max-width: 992px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .avatar-container {
            width: 130px;
        }
        
        .avatar-circle {
            width: 130px;
            height: 130px;
        }
    }
    
    @media (max-width: 768px) {
        .profile-card {
            margin-top: 1rem;
        }
        
        .card-body {
            padding: 1.25rem !important;
        }
        
        .card-header .d-flex {
            flex-direction: column;
            text-align: center;
        }
        
        .card-header .btn {
            margin-top: 0.75rem;
            width: auto;
            display: inline-block;
        }
        
        .avatar-container {
            margin-bottom: 1rem;
            width: 120px;
        }
        
        .avatar-circle {
            width: 120px;
            height: 120px;
        }
    }
</style>