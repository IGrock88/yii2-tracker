<?php

namespace common\models\query;

use common\models\Project;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Task]].
 *
 * @see \common\models\Task
 */
class TaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @param $userId
     * @return TaskQuery| ActiveQuery
     */
    public function byUser($userId)
    {
        $query = Project::find()->select('id')->byUser($userId);
        return $this->andWhere(['project_id' => $query]);
    }
    /**
     * {@inheritdoc}
     * @return \common\models\Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
