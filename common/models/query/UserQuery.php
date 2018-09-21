<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 18.09.2018
 * Time: 16:00
 */

namespace common\models\query;


use common\models\User;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{

    public function onlyActive()
    {
        return $this->andWhere(['active' => User::STATUS_ACTIVE]);
    }
}