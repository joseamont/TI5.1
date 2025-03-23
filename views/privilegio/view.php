<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

use app\models\User;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\Privilegio $model */

if (!Permiso::seccion('privilegio')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form='';

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Privilegios', 'url' => ['index']];
//\yii\web\YiiAsset::register($this);

?>
<div class="privilegio-view">
    <h3><?= Html::encode('Detalle del privilegio') ?></h3>
    <hr>

    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('privilegio', 'update')) {
            //  echo Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-success ']);

            //  Editar el privilegio utilizando _form.php en el modal 'modalForm' de abajo
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
        if (Permiso::accion('privilegio', 'delete')) {
            echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn  btn-sm btn-outline-danger',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalMensaje',
                'onClick' => '
                    $(\'#ModalLabelMensaje\').text(this.text);
                    $(\'#ModalBodyMensaje\').html(\'El privilegio será eliminado para todos los usuarios relacionados con el rol <b>' . $model->rol->nombre . '</b>. Confirmar que desea eliminar el privilegio. \');
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
                'attribute' => 'Rol asignado',
                'value' => function ($model) {
                    return $model->rol->getNombreEstatus();
                }
            ],
            [
                'attribute' => 'Sección asignada',
                'value' => function ($model) {
                    return $model->seccion->getNombreEstatus();
                }
            ],
            [
                'attribute' => 'Acción asignada',
                'value' => function ($model) {
                    if($model->accion)
                        return $model->accion->getNombreEstatus();
                    else
                        return '';
                }
            ],
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
                    $query = User::find()->where(['id_rol' => $model->id_rol]);
                    return GridView::widget([
                        /** dataProvider poblado con $model->users */
                        'dataProvider' => new ActiveDataProvider([
                            'query' => $query,
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

        ],
    ]) ?>


</div>


<!-- Modal donde se presenta _form para editar un privilegio  -->
<div class="modal fade modal-xl" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Editar privilegio
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