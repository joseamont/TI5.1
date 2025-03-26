<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\models\Permiso;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?> | <?= Yii::$app->name ?></title>
    <?php $this->head() ?>
    <style>
        :root {
            --primary-color: #0C4B54;
            --secondary-color: #E8F549;
            --accent-color: #3A7D8C;
            --text-dark: #2D3748;
            --text-light: #F7FAFC;
            --sidebar-width: 240px;
            --transition-speed: 0.3s;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #F8F9FA;
            color: var(--text-dark);
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: width var(--transition-speed);
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 10px;
        }
        
        .sidebar-header h4 {
            color: white;
            font-weight: 600;
            margin: 0;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }
        
        .sidebar-header h4 svg {
            margin-right: 10px;
        }
        
        .nav {
            padding: 0 15px;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 5px;
            transition: all var(--transition-speed);
            font-weight: 500;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--secondary-color);
            color: var(--text-dark);
            transform: translateX(3px);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .dropdown-menu {
            background-color: var(--accent-color) !important;
            border: none;
            border-radius: 6px;
            padding: 5px 0;
            margin: 5px 0 5px 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .dropdown-item {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 8px 15px;
            font-size: 0.9rem;
        }
        
        .dropdown-item:hover {
            background-color: var(--secondary-color) !important;
            color: var(--text-dark) !important;
        }
        
        .logout {
            width: 100%;
            text-align: left;
            padding: 12px 15px !important;
            border-radius: 6px;
            border: none;
            background: transparent;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .logout:hover {
            background-color: rgba(232, 245, 73, 0.2) !important;
            color: var(--secondary-color) !important;
        }
        
        /* Content Styles */
        .content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            flex-grow: 1;
            background-color: #F8F9FA;
            min-height: 100vh;
        }
        
        /* Breadcrumbs */
        .breadcrumb {
            background-color: transparent;
            padding: 0.75rem 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-header h4 span {
                display: none;
            }
            
            .nav-link span {
                display: none;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 1.3rem;
            }
            
            .content {
                margin-left: 70px;
            }
            
            .dropdown-menu {
                position: absolute !important;
                left: 70px !important;
                top: 0 !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
    <?php $this->beginBody() ?>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                    <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                </svg>
                <span><?= Yii::$app->name ?></span>
            </h4>
        </div>
        
        <?= Nav::widget([
            'options' => ['class' => 'nav flex-column'],
            'encodeLabels' => false,
            'items' => [
                Permiso::seccion('user') ? [
                    'label' => '<i class="bi bi-people"></i> <span>Usuarios</span>', 
                    'url' => ['/user/index']
                ] : '',
                
                Permiso::seccion('ticket') ? [
                    'label' => '<i class="bi bi-ticket-detailed"></i> <span>' . (Yii::$app->user->identity->id_rol == 4 ? 'Mis Tickets' : 'Tickets') . '</span>', 
                    'url' => ['/ticket/index']
                ] : '', 
                
                Permiso::seccion('usuario_tic') ? [
                    'label' => '<i class="bi bi-ticket-perforated"></i> <span>Mis Tickets</span>', 
                    'url' => ['/usuario-tic/index']
                ] : '',

                Permiso::seccion('asistencia') ? [
                    'label' => '<i class="bi bi-calendar-check"></i> <span>' . (Yii::$app->user->identity->id_rol == 3 ? 'Mis asistencias' : 'Asistencias') . '</span>', 
                    'url' => ['/asistencia/index']
                ] : '',
                
                Permiso::seccion('usuario_cal') ? [
                    'label' => '<i class="bi bi-journal-check"></i> <span>' . (Yii::$app->user->identity->id_rol == 3 ? 'Mis Calificaciones' : 'Calificaciones') . '</span>', 
                    'url' => ['/usuario-cal/index']
                ] : '', 
                
                Permiso::seccion('suscripciones') ? [
                    'label' => '<i class="bi bi-credit-card"></i> <span>Planes</span>',
                    'url' => ['#'],
                    'items' => [
                        Permiso::seccion('suscripciones') ? [
                            'label' => (Yii::$app->user->identity->id_rol == 4 ? 'Contratar servicio' : 'Planes'), 
                            'url' => ['/suscripciones/index']
                        ] : '',
                        Permiso::seccion('usuario_pla') ? [
                            'label' => (Yii::$app->user->identity->id_rol == 4 ? 'Mis Planes' : 'Planes Clientes'), 
                            'url' => ['/usuario-pla/index']
                        ] : '',
                    ]
                ] : '',
                
                Permiso::seccion('horario') ? [
                    'label' => '<i class="bi bi-clock"></i> <span>Horarios</span>',
                    'url' => ['#'],
                    'items' => [
                        Permiso::seccion('horario') ? [
                            'label' => 'Horarios', 
                            'url' => ['/horario/index']
                        ] : '',
                        Permiso::seccion('usuario_hor') ? [
                            'label' => (Yii::$app->user->identity->id_rol == 3 ? 'Mi Horario' : 'Horarios Trabajadores'), 
                            'url' => ['/usuario-hor/index']
                        ] : '',
                    ]
                ] : '',

                Permiso::seccion('configuracion') ? [
                    'label' => '<i class="bi bi-gear"></i> <span>Configuración</span>',
                    'url' => ['#'],
                    'items' => [
                        Permiso::seccion('rol') ? ['label' => 'Roles', 'url' => ['/rol/index']] : '',
                        Permiso::seccion('seccion') ? ['label' => 'Secciones', 'url' => ['/seccion/index']] : '',
                        Permiso::seccion('accion') ? ['label' => 'Acciones', 'url' => ['/accion/index']] : '',
                        Permiso::seccion('privilegio') ? ['label' => 'Privilegios', 'url' => ['/privilegio/index']] : '',
                    ]
                ] : '',
                
                Permiso::seccion('ticket') ? [
                    'label' => '<i class="bi bi-person"></i> <span>Perfil</span>', 
                    'url' => ['/persona/view']
                ] : '',
                
                Permiso::seccion('respaldo') ? [
                    'label' => '<i class="bi bi-database"></i> <span>Respaldo</span>', 
                    'url' => ['/respaldo/index']
                ] : '',
                
                Yii::$app->user->isGuest
                    ? [
                        'label' => '<i class="bi bi-box-arrow-in-right"></i> <span>Login</span>', 
                        'url' => ['/site/login']
                    ]
                    : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        '<i class="bi bi-box-arrow-left"></i> <span>Logout (' . Yii::$app->user->identity->getNombreUsuarioRol() . ')</span>',
                        ['class' => 'nav-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ],
        ]) ?>
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
            'options' => ['class' => 'breadcrumb'],
            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
            'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>'
        ]) ?>
        
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>