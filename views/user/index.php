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

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h3> <?= Html::encode($this->title) ?> </h3>
    <hr>

    <?php
        /** Verificar permiso */
        if (Permiso::accion('user', 'create')) {
            //   echo Html::a('Nuevo usuario', ['create'], ['class' => 'btn btn-outline-success btn-sm']);

            //  Crear un nuevo usuario utilizando _form.php en el modal 'modalForm' de abajo
            echo Html::a('Nuevo usuario', ['#'], [
                'class' => 'btn  btn-sm btn-outline-success',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalForm',
            ]);

            $form = $this->render('_form', ['model' => new User(), 'accion' => 'create']);
        }
        ?>
    <br><br>
    <?php //Buscador (_search.php) 
    echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        /** dataProvider poblado desde UserController - actionIndex() */
        'dataProvider' => $dataProvider,
        /** Formado de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //Boton nombre del usuario
            [
                'attribute' => 'Nombre del usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $user = $model->getNombreUsuarioEstatus();
                    /** Verificar permiso */
                    if (Permiso::accion('user', 'view')) {
                        $user = Html::a(
                            $model->getNombreUsuarioEstatus(),
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $user;
                }
            ],
            // Boton rol
            [
                'attribute' => 'Rol',
                'format' => 'raw',
                'value' => function ($model) {
                    $rol = $model->rol->getNombreEstatus();
                    /** Verificar permiso */
                    if (Permiso::accion('rol', 'view')) {
                        $rol = Html::a(
                            $model->rol->getNombreEstatus(),
                            ['/rol/view', 'id' => $model->id_rol],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->rol->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $rol;
                }
            ],

            //Correo
            'username',
            //Boton habilitar
            [
                'attribute' => 'Estatus',
                'format' => 'raw',
                'value' => function ($model) {
                    $userEstatus = $model->estatus ? 'Habilitado' : 'Deshabilitado';

                    /** Verificar permiso */
                    if (Permiso::accion('user', 'update-estatus')) {
                        $userEstatus = Html::beginForm(['update-estatus', 'id' => $model->id])
                            . Html::hiddenInput('User[estatus]', $model->estatus ? 0 : 1)
                            . Html::submitButton(
                                $model->estatus ? 'Deshabilitar' : 'Habilitar',
                                ['class' => 'btn btn-outline-secondary btn-sm']
                            )
                            . Html::endForm();
                    }

                    return $userEstatus;
                }
            ],
        ],
    ]);
    ?>
</div>

<!-- Modal donde se presenta _form para crear un nuevo rol  -->
<div class="modal fade modal-xl" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Nuevo usuario
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal-body">
                <div id="modalFormBody">
                    <?= $form; ?>
                </div>
            </div>
        </div>
    </div>
</div>