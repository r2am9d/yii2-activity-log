<?php

namespace r2am9d\activitylog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use r2am9d\activitylog\models\ActivityLog;

/**
 * ActivityLogSearch represents the model behind the search form of `r2am9d\activitylog\models\ActivityLog`.
 */
class ActivityLogSearch extends ActivityLog
{
    private $_query;

    const EVENT_BEFORE_QUERY = 'beforeQuery';
    const EVENT_AFTER_QUERY = 'afterQuery';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->on(self::EVENT_BEFORE_QUERY, [ $this, 'beforeQuery' ]);
        $this->on(self::EVENT_AFTER_QUERY, [ $this, 'afterQuery' ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['type', 'class', 'method', 'route', 'data', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $this->_query->where('0=1');
            return $dataProvider;
        }

        $this->_query = ActivityLog::find();

        // add conditions that should always apply here
        $this->trigger(self::EVENT_BEFORE_QUERY);

        // grid filtering conditions
        $this->_query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            // 'created_at', $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $this->_query->andFilterWhere([
            '>=', 'created_at', $this->created_at
        ]);

        $this->_query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'data', $this->data]);

        $dataProvider = new ActiveDataProvider([
            'query' => $this->_query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->trigger(self::EVENT_AFTER_QUERY);

        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    protected function beforeQuery($event)
    {   
        if(!empty($this->created_at)) {
            $this->created_at = strtotime($this->created_at);
        }
    }

    /**
     * @inheritdoc
     */
    protected function afterQuery($event)
    {
        if (!empty($this->created_at)) {
            $this->created_at = date('d F Y h:i:s A', $this->created_at);
            $this->_query->orderBy(['created_at' => SORT_ASC]);
        }
    }
}
