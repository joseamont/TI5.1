<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\Accion $model */

if (!Permiso::seccion('accion')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$form='';

$this->title = 'Acción: '.$model->getNombreEstatus();
$this->params['breadcrumbs'][] = ['label' => 'Acciones', 'url' => ['index']];
//\yii\web\YiiAsset::register($this);

?>
<div class="accion-view">

    <h3><?= Html::encode($this->title) ?></h3>
    <h4> Sección asociada: <?= $model->seccion->getNombreEstatus() ?></h4>

    <hr>

    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('accion', 'update')) {

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
        if (Permiso::accion('accion', 'delete')) {
            echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn  btn-sm btn-outline-danger',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modalMensaje',
                'onClick' => '
                    $(\'#ModalLabelMensaje\').text(this.text);
                    $(\'#ModalBodyMensaje\').html(\' Confirmar que desea eliminar la acción: <b>'. $model->nombre.'</b>. \');
                    $(\'#ModalButtonMensaje\').attr(\'href\',this);
                    '
            ]);
        }
        ?>
    </p>

    <h3><?= Html::encode('Roles relacionados a ' . $model->nombre) ?></h3>

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


</div>

<!-- Modal donde se presenta _form para editar un rol  -->
<div class="modal fade modal-lg" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Editar acción
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