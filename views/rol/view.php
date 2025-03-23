<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\Rol $model */

if (!Permiso::seccion('rol')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Rol: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
// \yii\web\YiiAsset::register($this);


?>
<div class="rol-view">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('rol', 'update')) {

            //  Editar el rol utilizando _form.php en el modal 'modalForm' de abajo
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
        if (Permiso::accion('rol', 'delete')) {
            echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn  btn-sm btn-outline-danger',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalMensaje',
                'onClick' => '
                    $(\'#ModalLabelMensaje\').text(this.text);
                    $(\'#ModalBodyMensaje\').html(\' Confirmar que desea eliminar el rol: <b>' . $model->nombre . '</b>.<br> Si tiene asignados usuarios o privilegios primero deberá quitar la asignación  \');
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
                'attribute' => 'Estatus',
                'format' => 'raw',
                'value' => function ($model) {
                    return  $model->estatus ? 'Habilitado' : 'Deshabilitado';
                }
            ],
            [
                'attribute' => 'Usuarios asignados',
                'format' => 'raw',
                'value' => function ($model) {
                    return GridView::widget([
                        /** dataProvider poblado con $model->users */
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $model->users,
                            'pagination' => ['pageSize' => 20]
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
                                    $user = $model->getNombreUsuarioEstatus();
                                    /** Verificar permiso */
                                    if (Permiso::accion('user', 'view')) {
                                        $user = Html::a(
                                            $model->getNombreUsuarioEstatus(),
                                            ['/user/view', 'id' => $model->id],
                                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->estatus ? 'btn-warning' : '')]
                                        );
                                    }

                                    return $user;
                                }
                            ],
                        ]
                    ]);
                }
            ],
            [
                'attribute' => 'Privilegios asignados',
                'format' => 'raw',
                'value' => function ($model) {
                    return GridView::widget([
                        /** dataProvider poblado con $model->users */
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $model->privilegios,
                            'pagination' => ['pageSize' => 20]
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
                                    return '<b>' . $model->seccion->getNombreEstatus() . '</b>' .
                                        ($model->accion ? ' - ' . $model->accion->getNombreEstatus() : '')
                                        . '<br>';
                                }
                            ],
                        ]
                    ]);
                }
            ]
        ],
    ]) ?>

</div>

<!-- Modal donde se presenta _form para editar un rol  -->
<div class="modal fade modal-lg" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Editar rol
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