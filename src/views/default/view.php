<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model r2am9d\activitylog\models\ActivityLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-log-view box box-primary">
    <div class="box-header">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'user_id',
                'type',
                'class',
                'method',
                'route',
                'data',
            ],
        ]) ?>
    </div>
</div>
