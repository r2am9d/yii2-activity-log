<?php

namespace r2am9d\activitylog\behaviors;

use __;
use Yii;
use yii\web\Controller;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use r2am9d\activitylog\models\ActivityLog;

/**
 * A customized logging behavior implementation 
 * used mainly for tracking user based web activities.
 * 
 * To use ActivityLogBehavior, insert the following code to your Controller or Model class:
 * 
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         \r2am9d\activitylog\behaviors\ActivityLogBehavior::className(),
 *     ];
 * }
 * ```
 * 
 * @author Ram Delatina <ram.delatina.29@gmail.com>
 */
class ActivityLogBehavior extends \yii\base\Behavior
{
    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            Controller::EVENT_AFTER_ACTION => 'log',

            ActiveRecord::EVENT_BEFORE_INSERT => 'log',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'log',
            ActiveRecord::EVENT_BEFORE_DELETE => 'log',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function log($event)
    {
        $model = $event->sender;
        $user = Yii::$app->user->identity;

        $type = explode('\\', dirname(get_class($model)))[1];
        $mType = ucfirst(Inflector::singularize($type));

        if($user !== null) {
            switch ($type) {
                case 'controllers':
                    $app = $this->getApp($model->module);

                    $class = get_class($model);
                    $route = $app->requestedRoute ?: '-';
                    $action = \array_key_exists('actionMethod', $model->action) ?
                        $model->action->actionMethod : 'error';
                    $method = $this->getMethod($action);

                    $queryParams = $model->request->queryParams;
                    $bodyParams = $model->request->bodyParams;
                    unset($bodyParams['_csrf']);

                    $data = \json_encode([
                        'queryParams' => $queryParams,
                        'bodyParams' => $bodyParams
                    ]);

                    if($action == 'error') {
                        $exception = Yii::$app->errorHandler->exception;
                        $data = \json_encode([
                            'type' => get_class($exception),
                            'statusCode' => $exception->statusCode,
                            'message' => $exception->getMessage(),
                            'queryParams' => $queryParams,
                            'bodyParams' => $bodyParams
                        ]);
                    }

                    $this->executeLog(
                        $user->id, $mType, $class, 
                        $method, $route, $data
                    );
                break;
                case 'models':
                    $data = '';
                    $route = '-';
                    $class = get_class($model);
                    $method = $this->getMethod($event->name);

                    $attributes = $model->getAttributes();
                    $oldAttributes = $model->getOldAttributes();

                    switch ($method) {
                        case 'insert':
                            $data = \json_encode([
                                'attributes' => $attributes
                            ]);
                        break;
                        case 'update':
                            $data = \json_encode([
                                'attributes' => $attributes,
                                'oldAttributes' => $oldAttributes
                            ]);
                        break;
                        case 'delete':
                            $data = \json_encode([
                                'attributes' => $attributes
                            ]);
                        break;
                    }

                    $this->executeLog(
                        $user->id, $mType, $class,
                        $method, $route, $data
                    );
                break;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    private function getApp($module)
    {
        return \array_key_exists('requestedRoute', $module) ?
            $module : $this->getApp($module->module);
    }

    /**
     * {@inheritdoc}
     */
    private function getMethod($method)
    {
        $arr = __::chain(explode(' ', Inflector::camel2words($method)))
            ->map(function($w) { return strtolower($w); })
            ->filter(function($w) { 
                return !(\strpos($w, 'action') !== false) && 
                    !(\strpos($w, 'before') !== false);
            })
            ->value();
        
        return implode('-', $arr);
    }

    /**
     * {@inheritdoc}
     */
    private function executeLog(...$args)
    {
        list($id, $type, $class, $method, $route, $data) = $args;

        $activityLog = new ActivityLog([
            'user_id' => $id,
            'type' => $type,
            'class' => $class,
            'method' => $method,
            'route' => $route,
            'data' => $data
        ]);

        $activityLog->save();
    }
}