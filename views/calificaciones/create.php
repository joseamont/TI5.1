<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Calificaciones $model */

$this->title = 'Create Calificaciones';
$this->params['breadcrumbs'][] = ['label' => 'Calificaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificaciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
