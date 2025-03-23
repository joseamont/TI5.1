<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UsuarioCal $model */

$this->title = 'Create Usuario Cal';
$this->params['breadcrumbs'][] = ['label' => 'Usuario Cals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-cal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
