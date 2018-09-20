<?php

namespace common\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Project_user]].
 *
 * @see \common\models\Project_user
 */
class ProjectUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @param $userId
     * @param null $role
     * @return ProjectUserQuery| ActiveQuery
     */
    public function byUser($userId, $role = null)
    {
        $this->andWhere(['user_id' => $userId]);
        if ($role != null){
            $this->andWhere(['role' => $role]);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Project_user[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Project_user|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
