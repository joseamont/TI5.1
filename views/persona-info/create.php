<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PersonaInfo $model */

$this->title = 'Create Persona Info';
$this->params['breadcrumbs'][] = ['label' => 'Persona Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
