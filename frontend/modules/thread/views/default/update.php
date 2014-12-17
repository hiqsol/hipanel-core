<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ticket',
]) . ' ' . $model->subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ticket-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
