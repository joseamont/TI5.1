<?php

use app\models\Privilegio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

use app\models\Permiso;
use yii\i18n\Formatter;

if (!Permiso::seccion('privilegio')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

/** @var yii\web\View $this */
/** @var app\models\PrivilegioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Privilegios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="privilegio-index">

    <h3>
        <?= Html::encode($this->title) ?>
    </h3>
    <hr>
    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('privilegio', 'create')) {
            //echo Html::a('Nuevo privilegio', ['create'], ['class' => 'btn btn-outline-success btn-sm']);

            //  Crear un nuevo rol utilizando _form.php en el modal 'modalForm' de abajo
            echo Html::a('Nuevo privilegio', ['#'], [
                'class' => 'btn  btn-sm btn-outline-success',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalForm',
            ]);

            $form = $this->render('_form', ['model' => new Privilegio(), 'accion' => 'create']);
        }
        ?>
    </p>
    <?php echo $this->render('_search', ['model' => $searchModel]);
    ?>
    <br>
    <div class="d-flex justify-content-end">
        <?php
        if (Permiso::accion('privilegio', 'update-estatus')) {
            echo Html::beginForm(['update-conjunto-estatus']);
            echo Html::submitButton(
                'Actualizar el estatus de los privilegios',
                ['class' => 'btn btn-outline-success btn-sm']
            );
        }
        ?>
    </div>

    <?= GridView::widget([
        /** dataProvider poblado desde PrivilegioController - actionIndex() */
        'dataProvider' => $dataProvider,
        /** Formado de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Boton Rol
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
            // Botón Sección
            [
                'attribute' => 'Sección',
                'format' => 'raw',
                'value' => function ($model) {
                    $seccion = $model->seccion->getNombreEstatus();
                    /** Verificar permiso */
                    if (Permiso::accion('seccion', 'view')) {
                        $seccion = Html::a(
                            $model->seccion->getNombreEstatus(),
                            ['/seccion/view', 'id' => $model->id_seccion],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->seccion->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $seccion;
                }
            ],
            // Botón acción
            [
                'attribute' => 'Acción',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!isset($model->accion)) {
                        return '';
                    }

                    $accion = $model->accion->getNombreEstatus();
                    /** Verificar permiso */
                    if (Permiso::accion('accion', 'view')) {
                        $accion = Html::a(
                            $model->accion->getNombreEstatus(),
                            ['/accion/view', 'id' => $model->id_accion],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->accion->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $accion;
                }
            ],
            [
                'attribute' => 'Estatus',
                'format' => 'raw',
                'value' => function ($model) {

                    return '<div class="form-check form-switch">' .
                        '<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ' .
                        'name="Habilitar[' . $model->id . ']" ' .
                        ($model->estatus ? 'checked' : '') . ' >' .
                        '<input type="hidden" name="Deshabilitar[' . $model->id . ']" value="0" >' .
                        '</div>';


                    return  ' <input type="checkbox" name="Habilitar[' . $model->id . ']" ' .
                        ($model->estatus ? 'checked' : '') . ' >' .
                        '<input type="hidden" name="Deshabilitar[' . $model->id . ']" value="0" >';
                }
            ],
            //Boton Editar
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {
                    $botones = '';

                    if (Permiso::accion('privilegio', 'view')) {
                        $botones .= ' &nbsp ' . Html::a(
                            'Detalle',
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm ']
                        );
                    }

                    return $botones;
                }
            ],
        ],
    ]); ?>

    <?= Html::endForm(); ?>

</div>

<!-- Modal donde se presenta _form para crear un nuevo rol  -->
<div class="modal fade modal-xl" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Nuevo privilegio
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