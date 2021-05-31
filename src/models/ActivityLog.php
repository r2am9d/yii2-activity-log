<?php

namespace r2am9d\activitylog\models;

use Yii;
use yii\web\User; // @todo

/**
 * This is the model class for table "activity_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $class
 * @property string $method
 * @property string|null $route
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 */
class ActivityLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_log';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'class', 'method'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['type', 'data'], 'string'],
            [['class', 'method', 'route'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'class' => 'Class',
            'method' => 'Method',
            'route' => 'Route',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
