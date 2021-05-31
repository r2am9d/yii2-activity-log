<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model r2am9d\activitylog\models\ActivityLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-log-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'type')->dropDownList([ 'Controller' => 'Controller', 'Model' => 'Model', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'data')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
