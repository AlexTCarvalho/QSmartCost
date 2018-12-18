<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Qhiboard */

$this->title = 'Update Qhiboard: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Qhiboards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="qhiboard-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>