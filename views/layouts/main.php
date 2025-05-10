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
            --primary-light: #3A7D8C;
            --primary-dark: #062A30;
            --secondary-color: #E8F549;
            --accent-color: #3A7D8C;
            --text-dark: #2D3748;
            --text-light: #F7FAFC;
            --sidebar-width: 260px;
            --transition-speed: 0.3s;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 16px;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #F8F9FA;
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: var(--text-light);
            padding: 0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: var(--shadow-md);
            transition: width var(--transition-speed);
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.5rem;
            background-color: rgba(0,0,0,0.1);
        }
        
        .sidebar-header h4 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            letter-spacing: 0.5px;
        }
        
        .sidebar-header h4 svg {
            margin-right: 12px;
            color: var(--secondary-color);
        }
        
        .nav {
            padding: 0.5rem 1rem;
            flex-grow: 1;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 0.25rem;
            transition: all var(--transition-speed);
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--secondary-color);
            color: var(--primary-dark);
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
        }
        
        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .dropdown-menu {
            background-color: var(--primary-light) !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.25rem 0;
            margin: 0.25rem 0 0.25rem 1rem;
            box-shadow: var(--shadow-md);
        }
        
        .dropdown-item {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: var(--secondary-color) !important;
            color: var(--primary-dark) !important;
            padding-left: 1.25rem;
        }
        
        .logout {
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem !important;
            border-radius: var(--radius-sm);
            border: none;
            background: transparent;
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            margin-top: auto;
            margin-bottom: 1rem;
            transition: all var(--transition-speed);
        }
        
        .logout:hover {
            background-color: rgba(232, 245, 73, 0.15) !important;
            color: var(--secondary-color) !important;
        }
        
        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin var(--transition-speed);
        }
        
        /* Content Area */
        .content {
            padding: 2rem 2.5rem;
            flex: 1;
        }
        
        /* Breadcrumbs */
        .breadcrumb {
            background-color: transparent;
            padding: 0.75rem 0;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .breadcrumb-item a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .breadcrumb-item.active {
            color: var(--text-dark);
            font-weight: 600;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--primary-light);
        }
        
        /* Footer Styles */
        .main-footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: white;
            padding: 1.5rem 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
        }
        
        .footer-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .footer-links a:hover {
            color: var(--secondary-color);
        }
        
        .footer-copyright {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
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
            
            .main-wrapper {
                margin-left: 80px;
            }
            
            .content {
                padding: 1.5rem;
            }
            
            .dropdown-menu {
                position: absolute !important;
                left: 80px !important;
                top: 0 !important;
                min-width: 200px;
            }
            
            .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .footer-links {
                order: -1;
            }
        }
        
        @media (max-width: 576px) {
            .content {
                padding: 1.25rem;
            }
            
            .main-footer {
                padding: 1.25rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                    'url' => ['/user/index'],
                    'active' => $this->context->route == 'user/index'
                ] : '',
                
                Permiso::seccion('ticket') ? [
                    'label' => '<i class="bi bi-ticket-detailed"></i> <span>' . (Yii::$app->user->identity->id_rol == 4 ? 'Mis Tickets' : 'Tickets') . '</span>', 
                    'url' => ['/ticket/index'],
                    'active' => $this->context->route == 'ticket/index'
                ] : '', 
                
                Permiso::seccion('usuario_tic') ? [
                    'label' => '<i class="bi bi-ticket-detailed"></i> <span>' . (Yii::$app->user->identity->id_rol == 3 ? 'Mis Tickets' : 'Tickets Asignados') . '</span>',
                    'url' => ['/usuario-tic/index'],
                    'active' => $this->context->route == 'usuario-tic/index'
                ] : '',

                Permiso::seccion('user') ? [
                    'label' => '<i class="bi bi-person"></i> <span>Calificaciones</span>', 
                    'url' => ['/calificacion/index'],
                    'active' => $this->context->route == 'calificacion/index'
                ] : '',

                Permiso::seccion('asistencia') ? [
                    'label' => '<i class="bi bi-calendar-check"></i> <span>' . (Yii::$app->user->identity->id_rol == 3 ? 'Mis asistencias' : 'Asistencias') . '</span>', 
                    'url' => ['/asistencia/index'],
                    'active' => $this->context->route == 'asistencia/index'
                ] : '',
                
                Permiso::seccion('suscripciones') ? [
                    'label' => '<i class="bi bi-credit-card"></i> <span>Planes</span>',
                    'url' => ['#'],
                    'active' => in_array($this->context->route, ['suscripciones/index', 'usuario-pla/index']),
                    'items' => [
                        Permiso::seccion('suscripciones') ? [
                            'label' => (Yii::$app->user->identity->id_rol == 4 ? 'Contratar servicio' : 'Planes'), 
                            'url' => ['/suscripciones/index'],
                            'active' => $this->context->route == 'suscripciones/index'
                        ] : '',
                        Permiso::seccion('usuario_pla') ? [
                            'label' => (Yii::$app->user->identity->id_rol == 4 ? 'Mis Planes' : 'Planes Clientes'), 
                            'url' => ['/usuario-pla/index'],
                            'active' => $this->context->route == 'usuario-pla/index'
                        ] : '',
                    ]
                ] : '',
                
                Permiso::seccion('horario') ? [
                    'label' => '<i class="bi bi-clock"></i> <span>Horarios</span>',
                    'url' => ['#'],
                    'active' => in_array($this->context->route, ['horario/index', 'usuario-hor/index']),
                    'items' => [
                        Permiso::seccion('horario') ? [
                            'label' => 'Horarios', 
                            'url' => ['/horario/index'],
                            'active' => $this->context->route == 'horario/index'
                        ] : '',
                        Permiso::seccion('usuario_hor') ? [
                            'label' => (Yii::$app->user->identity->id_rol == 3 ? 'Mi Horario' : 'Horarios Trabajadores'), 
                            'url' => ['/usuario-hor/index'],
                            'active' => $this->context->route == 'usuario-hor/index'
                        ] : '',
                    ]
                ] : '',

                Permiso::seccion('configuracion') ? [
                    'label' => '<i class="bi bi-gear"></i> <span>Configuración</span>',
                    'url' => ['#'],
                    'active' => in_array($this->context->route, ['rol/index', 'seccion/index', 'accion/index', 'privilegio/index']),
                    'items' => [
                        Permiso::seccion('rol') ? ['label' => 'Roles', 'url' => ['/rol/index'], 'active' => $this->context->route == 'rol/index'] : '',
                        Permiso::seccion('seccion') ? ['label' => 'Secciones', 'url' => ['/seccion/index'], 'active' => $this->context->route == 'seccion/index'] : '',
                        Permiso::seccion('accion') ? ['label' => 'Acciones', 'url' => ['/accion/index'], 'active' => $this->context->route == 'accion/index'] : '',
                        Permiso::seccion('privilegio') ? ['label' => 'Privilegios', 'url' => ['/privilegio/index'], 'active' => $this->context->route == 'privilegio/index'] : '',
                    ]
                ] : '',
                
                Permiso::seccion('ticket') ? [
                    'label' => '<i class="bi bi-person"></i> <span>Perfil</span>', 
                    'url' => ['/persona/view'],
                    'active' => $this->context->route == 'persona/view'
                ] : '',
                
                Permiso::seccion('respaldo') ? [
                    'label' => '<i class="bi bi-database"></i> <span>Respaldo</span>', 
                    'url' => ['/respaldo/index'],
                    'active' => $this->context->route == 'respaldo/index'
                ] : '',
                
                Yii::$app->user->isGuest
                    ? [
                        'label' => '<i class="bi bi-box-arrow-in-right"></i> <span>Login</span>', 
                        'url' => ['/site/login'],
                        'active' => $this->context->route == 'site/login'
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

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Content Area -->
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
        
        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="/inicio">Inicio</a>
                    <a href="/contacto">Contacto</a>
                    <a href="/terminos">Términos</a>
                    <a href="/privacidad">Privacidad</a>
                </div>
                <div class="footer-brand">
                    <i class="bi bi-play-circle-fill" style="color: var(--secondary-color);"></i>
                    <span><?= Yii::$app->name ?></span>
                </div>
                <div class="footer-copyright">
                    © <?= date('Y') ?> Todos los derechos reservados
                </div>
            </div>
        </footer>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>