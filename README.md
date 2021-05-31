<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 Activity Log Module</h1>
    <br>
</p>

A simplified module for tracking user web-based activities

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

Either run

```
php composer.phar require --prefer-dist r2am9d/yii2-activity-log
```

or add

```
"r2am9d/yii2-activity-log": "*"
```

to the require-dev section of your `composer.json` file.

Usage
-----------

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

Afterwards apply the custom behavior to your Controller or Model class via the inherited "behaviors" function.

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

You can then access the module through the following URL:

```
http://localhost/path/to/index?r=activity-log
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index/activity-log
```