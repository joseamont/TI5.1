<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

use app\models\User;
use app\models\Permiso;
use PhpParser\Node\Expr\Cast\Array_;

if (!Permiso::seccion('user')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$form='';
/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Usuario: ' . $model->getNombreUsuario();
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
//\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('user', 'update')) {
            //  Editar el usuario utilizando _form.php en el modal 'modalForm' de abajo
            echo Html::a('Editar', ['#'], [
                'class' => 'btn  btn-sm btn-outline-success',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalForm',
            ]);

            $form = $this->render('_form', ['model' => $model, 'accion' => 'update']);
        }
        ?>
        <?php

        /** Verificar permiso */
        if (Permiso::accion('user', 'delete')) {
            echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn  btn-sm btn-outline-danger',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalMensaje',
                'onClick' => '
                    $(\'#ModalLabelMensaje\').text(this.text);
                    $(\'#ModalBodyMensaje\').html(\' Confirmar que desea eliminar al usuario:<b> ' . $model->getNombreUsuario() . '</b> \');
                    $(\'#ModalButtonMensaje\').attr(\'href\',this);
                    '
            ]);
        }
        ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'username',
            /** Boton para cambiar estatus */
            [
                'attribute' => 'Estatus',
                'format' => 'raw',
                'value' => function ($model) {
                    return  $model->estatus ? 'Habilitado' : 'Deshabilitado';
                }
            ],
            [
                'attribute' => 'Privilegios asignados',
                'format' => 'raw',
                'value' => function ($model) {
                    $arrayPrivilegios = Array();
                    foreach( $model->rol->privilegios as $privilegio){
                        if( $privilegio->estatus){
                            $arrayPrivilegios[]=$privilegio;
                        }
                    }
                    return GridView::widget([
                        /** dataProvider poblado con $model->rol->privilegios */
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $arrayPrivilegios,
                            'pagination' => ['pageSize' => 25]
                        ]),
                        /** Formado de botones de paginación */
                        'pager' => [
                            'class' => \yii\bootstrap5\LinkPager::class,
                            'firstPageLabel' => 'Inicio ',
                            'lastPageLabel' => ' Último',
                        ],
                        'showHeader' => false,
                        'columns' => [
                            [
                                'attribute' => 'Usuario',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '<b> Sección: ' . $model->seccion->getNombreEstatus() . '</b>' .
                                        ($model->accion ?
                                            (' - ' . $model->accion->getNombreEstatus()) : '') . '<br>';
                                }
                            ],
                        ]
                    ]);
                }
            ],
        ],
    ]);
    ?>
</div>

<!-- Modal donde se presenta _form para editar un usuario  -->
<div class="modal fade modal-xl modal-dialog-scrollable" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Editar usuario
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