<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Calificacion $model */

$this->title = 'Calificar servicio';
$this->params['breadcrumbs'][] = ['label' => 'Calificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
