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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 200px;
            background-color: #0C4B54;
            color: white;
            padding: 15px;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover {
            background-color: #E8F549;
            color: #040404;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
            flex-grow: 1;
        }
        .dropdown-menu {
            background-color: #0C4B54 !important;
        }
        .dropdown-menu a {
            color: white !important;
        }
        .dropdown-menu a:hover {
            background-color: #E8F549 !important;
            color: #040404 !important;
        }
    </style>
</head>
<body>
    <?php $this->beginBody() ?>

    <!-- Menú lateral -->
    <div class="sidebar">
        <h4><?= Yii::$app->name ?></h4>
        <?= Nav::widget([
            'options' => ['class' => 'nav flex-column'],
            'items' => [
                Permiso::seccion('user') ? ['label' => 'Usuarios', 'url' => ['/user/index']] : '',
                Permiso::seccion('ticket') ? ['label' => 'Tickets', 'url' => ['/ticket/index']] : '',
                Permiso::seccion('user') ? ['label' => 'Asistencias', 'url' => ['/asistencia/index']] : '',
                Permiso::seccion('user') ? ['label' => 'Calificaciones', 'url' => ['/usuario-cal/index']] : '',
                
                Permiso::seccion('suscripciones') ? [
                    'label' => 'Planes',
                    'url' => ['#'],
                    'items' => [
                        Permiso::seccion('user') ? ['label' => 'Planes', 'url' => ['/suscripciones/index']] : '',
                        Permiso::seccion('seccion') ? ['label' => 'Planes Clientes', 'url' => ['/usuario-pla/index']] : '',
                    ]
                ] : '',
                
                Permiso::seccion('horario') ? [
                    'label' => 'Horarios',
                    'url' => ['#'],
                    'items' => [
                        Permiso::seccion('user') ? ['label' => 'Horarios', 'url' => ['/horario/index']] : '',
                        Permiso::seccion('seccion') ? ['label' => 'Hoarios Trabajadores', 'url' => ['/usuario-hor/index']] : '',
                    ]
                ] : '',

                Permiso::seccion('configuracion') ? [
                    'label' => 'Configuración',
                    'url' => ['#'],
                    'items' => [
                        Permiso::seccion('rol') ? ['label' => 'Roles', 'url' => ['/rol/index']] : '',
                        Permiso::seccion('seccion') ? ['label' => 'Secciones', 'url' => ['/seccion/index']] : '',
                        Permiso::seccion('accion') ? ['label' => 'Acciones', 'url' => ['/accion/index']] : '',
                        Permiso::seccion('privilegio') ? ['label' => 'Privilegios', 'url' => ['/privilegio/index']] : '',
                    ]
                ] : '',
                Permiso::seccion('user') ? ['label' => 'Perfil', 'url' => ['/asistencia/index']] : '',
                //
                Permiso::seccion('respaldo') ? ['label' => 'Respaldo', 'url' => ['/respaldo/index']] : '',
                Yii::$app->user->isGuest
                    ? ['label' => 'Login', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->getNombreUsuarioRol() . ')',
                        ['class' => 'nav-link btn btn-link text-light logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ],
        ]) ?>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
