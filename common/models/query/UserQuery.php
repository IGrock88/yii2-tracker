<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 18.09.2018
 * Time: 16:00
 */

namespace common\models\query;


use common\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{

    /**
     * @return UserQuery|ActiveQuery
     */
    public function onlyActive()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }
}