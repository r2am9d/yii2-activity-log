<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Inflector;
use kartik\datetime\DateTimePicker;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel r2am9d\activitylog\models\ActivityLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activity Logs';
$this->params['breadcrumbs'][] = $this->title;
$mTitle = str_replce(' ', '-', Inflector::singularize(strtolower($this->title)));
?>
<div class="activity-log-index">

    <?= GridView::widget([
        'id' => "{$mTitle}-grid",
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => false,
            'options' => [ 'enablePushState' => false ]
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => ['before' => '', 'footer' => '',],
        'panelPrefix' => "{$mTitle}-panel panel panel-",
        'panelTemplate' => '{panelBefore}{items}{panelFooter}',
        'panelBeforeTemplate' => '{toggleData}',
        'panelFooterTemplate' => "<div class='table-summary'>{summary}{pager}</div>",
        'headerRowOptions' => ['id' => "{$mTitle}-grid-headers"],
        'filterRowOptions' => ['id' => "{$mTitle}-grid-filters"],
        'rowOptions' => ['class' => "{$mTitle}-grid-items"],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
            [
                'group' => true,
                'label' => 'User',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $users,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
                'filterInputOptions' => [
                    'placeholder' => 'Choose a user ..'
                ],
                'attribute' => 'user_id',
                'value' => function($x) {
                    return $x->user->profile->name;
                },
                // 'headerOptions' => [],
                // 'filterOptions' => [],
                // 'contentOptions' => ['class' => 'kv-align-left kv-align-top'],
            ],
            [
                'group' => true,
                'attribute' => 'type',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    'Controller' => 'Controller',
                    'Model' => 'Model',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
                'filterInputOptions' => [
                    'placeholder' => 'Choose a type ..'
                ],
            ],
            [
                'group' => true,
                'attribute' => 'class',
            ],
            [
                'group' => true,
                'attribute' => 'method',
            ],
            [
                'group' => true,
                'attribute' => 'route',
            ],
            [
                'attribute' => 'data',
            ],
            [
                'group' => true,
                'attribute' => 'created_at',
                'filterType' => GridView::FILTER_DATETIME,
                'filterWidgetOptions' => [
                    'removeButton' => false,
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'showMeridian' => true,
                        'todayHighlight' => true,
                        'format' => 'dd MM yyyy HH:ii:ss P',
                    ]
                ],
                'filterInputOptions' => [
                    'style' => 'width: 22rem;',
                    'placeholder' => 'Choose date & time ..',
                ],
                'format' => ['date', 'php:d F Y h:i:s A'],
            ],
            // 'updated_at',

            [
                'visible' => false, # Temp hidden
                'class' => 'kartik\grid\ActionColumn',
                'template' => '<div class="action-buttons">{view} {update} {delete}</div>',
                'buttons' => [
                    'view' => function($url, $x, $key) {
                        return Html::a(
                            'View '.FA::icon('eye', ['aria-hidden' => 'true'])->fixedWidth(),
                            Url::to(['view', 'id' => $x->id]), [
                                'title' => 'View',
                                'class' => 'btn btn-flat btn-primary',
                                'data' => ['pjax' => '0']
                            ]
                        );
                    },
                    'update' => function($url, $x, $key) {
                        return Html::a(
                            'Update '.FA::icon('pencil', ['aria-hidden' => 'true'])->fixedWidth(),
                            Url::to(['update', 'id' => $x->id]), [
                                'title' => 'Update',
                                'class' => 'btn btn-flat btn-warning',
                                'data' => ['pjax' => '0']
                            ]
                        );
                    },
                    'delete' => function($url, $x, $key) {
                        return Html::a(
                            'Delete '.FA::icon('trash', ['aria-hidden' => 'true'])->fixedWidth(),
                            Url::to(['delete', 'id' => $x->id]), [
                                'title' => 'Delete',
                                'class' => 'btn btn-flat btn-danger btn-cfm',
                                'data' => [
                                    'pjax' => '0',
                                    'method' => 'post',
                                    'type' => 'danger',
                                    'ok-icon' => 'trash',
                                    'ok-label' => 'Delete',
                                    'confirm' => 'Are you sure you want to delete this?'
                                ]
                            ]
                        );
                    },
                ]
            ],
        ],
    ]); ?>

</div>

<?php
$JS = <<< 'JS'
;
    $('span.kv-datetime-remove').on('click', e => {
        const filter = $(e.currentTarget).prev()
        $(filter).datetimepicker('hide').click()
    })

    $(document).on('afterFilter', '#activity-log-grid', e => {
        const filters = Array
            .from($(e.target).find('#activity-log-grid-filters').children())
            .map(el => $(el).find("[name*='LogSearch']"))

        const filter = filters
            .filter(el => $(el).attr('name').includes('created_at'))
            .pop()

        $(filter).datetimepicker('hide')
    })
;
JS;
$this->registerJs($JS);
?>