<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 Activity Log Module</h1>
    <br>
</p>

A simplified module for tracking user web-based activities

## Installation

The preferred way to install this module is through [composer](http://getcomposer.org/download/):

Either run

```
php composer.phar require --prefer-dist r2am9d/yii2-activity-log
```

or add to the require-dev section of your `composer.json` file.

```
"r2am9d/yii2-activity-log": "*"
```

Once the extension is installed, simply add the lines below to your "modules" application configuration.

```php
return [
    'modules' => [
        'activity-log' => [
            'class' => 'r2am9d\activitylog\Module',
        ],
    ],
];
```

Then add these lines to your "controllerMap" application configuration.

```php
return [
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@app/migrations',
                '@vendor/r2am9d/yii2-activity-log/migrations',
            ],
        ],
    ],
];
```

Lastly, run the migrations.

```bash
~$ php yii migrate
```

## Usage

Apply the custom behavior to your Controller or Model class via inherited "behaviors" function.

```php
/**
 * {@inheritdoc}
 */
public function behaviors()
{
    return [
        \r2am9d\activitylog\behaviors\ActivityLogBehavior::className(),
    ];
}
```

## Accessing module

You can then access the module through the following URL:

```
http://localhost/path/to/index?r=activity-log
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index/activity-log
```