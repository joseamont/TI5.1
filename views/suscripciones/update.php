<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Suscripciones $model */

$this->title = 'Update Suscripciones: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Suscripciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="suscripciones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
