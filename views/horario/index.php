<?php

use app\models\Horario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\HorarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('horario')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Horarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horario-index">

<h3> <?= Html::encode($this->title) ?> </h3>
    <hr>

    <?php
    /** Verificar permiso */
    if (Permiso::accion('horario', 'create')) {

        //  Crear un nuevo rol utilizando _form.php en el modal 'modalForm' de abajo
        echo Html::a('Nuevo Horario', ['#'], [
            'class' => 'btn  btn-sm btn-outline-success',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalForm',
        ]);
        
        $form = $this->render('_form', ['model' => new Horario(), 'accion' => 'create']);
    }
    ?>


<br><br>

<?= GridView::widget([
        /** dataProvider poblado desde TicketController - actionIndex() */
        'dataProvider' => $dataProvider,
        /** Formado de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dias',
            'hora_inicio',
            'hora_fin',
            'tipo',
        ],
    ]); ?>


</div>

<!-- Modal donde se presenta _form para crear un nuevo rol  -->
<div class="modal fade modal-lg" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Nuevo Ticket
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