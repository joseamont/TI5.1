<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Respuesta $model */

$this->title = 'Create Respuesta';
$this->params['breadcrumbs'][] = ['label' => 'Respuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
