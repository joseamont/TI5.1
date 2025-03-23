<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UsuarioCal $model */

$this->title = 'Update Usuario Cal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Cals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-cal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
