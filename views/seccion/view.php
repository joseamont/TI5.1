<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */

if (!Permiso::seccion('seccion')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = $model->getNombreEstatus();
$this->params['breadcrumbs'][] = ['label' => 'Secciones', 'url' => ['index']];
//\yii\web\YiiAsset::register($this);
?>
<div class="seccion-view">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>

    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('seccion', 'update')) {
        
            //  Editar la sección utilizando _form.php en el modal 'modalForm' de abajo
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
                    $(\'#ModalBodyMensaje\').html(\' Confirmar que desea eliminar la sección: <b>'. $model->nombre.'</b>. <br> Si tiene asignados roles, secciones o acciones primero deberá quitar la asignación  \');
                    $(\'#ModalButtonMensaje\').attr(\'href\',this);
                    '
            ]);
        }
        ?>
    </p>

    <h3><?= Html::encode('Roles relacionadas a ' . $model->nombre) ?></h3>

    <?php
    $roles = array();
    foreach ($model->privilegios as $p) {
        if (!in_array($p->rol, $roles))
            $roles[] = $p->rol;
    }

    echo GridView::widget([
        /** dataProvider poblado con $roles */
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $roles,
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
                'attribute' => 'Nombre',
                'format' => 'raw',
                'value' => function ($model) {
                    $rol = $model->getNombreEstatus();

                    /** Verificar permiso */
                    if (Permiso::accion('rol', 'view')) {
                        $rol = Html::a(
                            $model->getNombreEstatus(),
                            ['/rol/view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $rol;
                }
            ],
        ]
    ]);
    ?>

    <h3><?= Html::encode('Acciones relacionadas a ' . $model->nombre) ?></h3>

    <?= GridView::widget([
        /** dataProvider poblado con $model->accions */
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->accions,
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
                'attribute' => 'Nombre',
                'format' => 'raw',
                'value' => function ($model) {
                    $accion =  $model->getNombreEstatus();

                    /** Verificar permiso */
                    if (Permiso::accion('accion', 'view')) {
                        $accion = Html::a(
                            $model->getNombreEstatus(),
                            ['/accion/view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->estatus ? 'btn-info' : '')]
                        );
                    }

                    return $accion;
                }
            ],
            [
                'attribute' => 'Estatus',
                'format' => 'raw',
                'value' => function ($model) {
                    $estatus = $model->estatus ? 'Habilitado' : 'Deshabilitado';

                    /** Verificar permiso */
                    if (Permiso::accion('accion', 'update-estatus')) {
                        $estatus = Html::beginForm(['/accion/update-estatus-seccion', 'id' => $model->id])
                            . Html::hiddenInput('Accion[estatus]', $model->estatus ? 0 : 1)
                            . Html::submitButton(
                                $model->estatus ? 'Deshabilitar' : 'Habilitar',
                                ['class' => 'btn btn-outline-secondary btn-sm']
                            )
                            . Html::endForm();
                    }

                    return $estatus;
                }
            ],
            [
                'attribute' => 'Eliminar',
                'format' => 'raw',
                'value' => function ($model) {

                    /** Verificar permiso */
                    if (Permiso::accion('accion', 'delete')) {
                        return Html::a('Eliminar', ['/accion/delete-seccion', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    } else {
                        return '';
                    }
                }
            ]
        ]
    ]);
    ?>

    <h3><?= Html::encode('Sub secciones de ' . $model->nombre) ?></h3>

    <?php echo GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->seccions,
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
                'attribute' => 'Secciones',
                'format' => 'raw',
                'value' => function ($model) {
                    $seccion =  $model->getNombreEstatus();

                    /** Verificar permiso */
                    if (Permiso::accion('seccion', 'view')) {
                        $seccion = Html::a(
                            $model->getNombreEstatus(),
                            ['/seccion/view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $seccion;
                }
            ],
        ],
    ]);

    ?>

</div>


<!-- Modal donde se presenta _form para editar una sección  -->
<div class="modal fade modal-xl" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Editar Sección
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