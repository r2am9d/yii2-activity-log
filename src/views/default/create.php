<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model r2am9d\activitylog\models\ActivityLog */

$this->title = 'Create Activity Log';
$this->params['breadcrumbs'][] = ['label' => 'Activity Log', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-log-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
