<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

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
            <div class="card shadow-lg border-0 profile-card">
                <div class="card-header py-4" style="background-color: #0C4B54; border-bottom: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h3 mb-0 text-white">
                            <i class="bi bi-person-badge me-2"></i><?= Html::encode($this->title) ?>
                        </h2>
                        <div>
                            <?= Html::a('<i class="bi bi-pencil-fill me-2"></i>Editar Perfil', ['update', 'id' => $model->id], [
                                'class' => 'btn btn-outline-light btn-lg rounded-pill px-4'
                            ]) ?>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-5 mb-md-0">
                            <div class="avatar-container mb-4">
                                <div class="avatar-circle d-flex align-items-center justify-content-center" 
                                     style="background-color: rgba(12, 75, 84, 0.1); border: 3px solid #0C4B54;">
                                    <i class="bi bi-person-fill" style="font-size: 3rem; color: #0C4B54;"></i>
                                </div>
                            </div>
                            <h3 class="mb-2" style="color: #0C4B54;"><?= Html::encode($model->nombre . ' ' . $model->apellido_paterno) ?></h3>
                            <p class="text-muted mb-0"><i class="bi bi-person-lines-fill me-2"></i>Perfil de usuario</p>
                            
                            <div class="mt-4 pt-3 border-top">
                                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-2">
                                    <i class="bi bi-envelope me-1"></i> Contactar
                                </button>
                                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="bi bi-share me-1"></i> Compartir
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-7">
                            <div class="profile-details">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'options' => ['class' => 'table table-profile'],
                                    'attributes' => [
                                        [
                                            'attribute' => 'id',
                                            'label' => '<i class="bi bi-person-vcard me-2"></i> ID de Usuario',
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'py-3'],
                                            'captionOptions' => ['class' => 'fw-bold']
                                        ],
                                        [
                                            'attribute' => 'nombre',
                                            'label' => '<i class="bi bi-person me-2"></i> Nombre',
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'py-3'],
                                            'captionOptions' => ['class' => 'fw-bold']
                                        ],
                                        [
                                            'attribute' => 'apellido_paterno',
                                            'label' => '<i class="bi bi-person me-2"></i> Apellido Paterno',
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'py-3'],
                                            'captionOptions' => ['class' => 'fw-bold']
                                        ],
                                        [
                                            'attribute' => 'apellido_materno',
                                            'label' => '<i class="bi bi-person me-2"></i> Apellido Materno',
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'py-3'],
                                            'captionOptions' => ['class' => 'fw-bold']
                                        ],
                                        // Puedes agregar más atributos aquí si lo necesitas
                                    ],
                                    'template' => '<tr><th class="w-40">{label}</th><td class="text-dark">{value}</td></tr>'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer py-3" style="background-color: #f8f9fa; border-top: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-clock-history me-1"></i> Última actualización: <?= date('d/m/Y H:i') ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .profile-card {
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 3rem;
        margin-top: 2rem;
    }
    
    .card-header {
        border-radius: 16px 16px 0 0 !important;
    }
    
    .avatar-container {
        position: relative;
        margin: 0 auto;
        width: 180px;
    }
    
    .avatar-circle {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .avatar-circle:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 25px rgba(12, 75, 84, 0.15);
    }
    
    .table-profile {
        width: 100%;
    }
    
    .table-profile th {
        font-weight: 600;
        color: #0C4B54;
        padding-right: 1.5rem;
        vertical-align: middle;
        font-size: 0.95rem;
    }
    
    .table-profile td {
        font-weight: 500;
        vertical-align: middle;
        font-size: 1rem;
    }
    
    .table-profile tr:not(:last-child) {
        border-bottom: 1px solid #f1f3f5;
    }
    
    .btn-outline-light {
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
    }
    
    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: white;
        color: white;
    }
    
    .profile-details {
        background-color: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(12, 75, 84, 0.08);
    }
    
    @media (max-width: 992px) {
        .card-body {
            padding: 2.5rem !important;
        }
        
        .avatar-container {
            width: 150px;
        }
        
        .avatar-circle {
            width: 150px;
            height: 150px;
        }
    }
    
    @media (max-width: 768px) {
        .profile-card {
            margin-top: 1rem;
        }
        
        .card-body {
            padding: 2rem !important;
        }
        
        .card-header .d-flex {
            flex-direction: column;
            text-align: center;
        }
        
        .card-header .btn {
            margin-top: 1rem;
            width: 100%;
        }
        
        .avatar-container {
            margin-bottom: 1.5rem;
        }
    }
</style>