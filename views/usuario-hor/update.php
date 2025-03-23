<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UsuarioHor $model */

$this->title = 'Update Usuario Hor: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Hors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-hor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
