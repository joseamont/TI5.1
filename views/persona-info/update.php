<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PersonaInfo $model */

$this->title = 'Update Persona Info: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Persona Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="persona-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
