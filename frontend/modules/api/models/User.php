<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 10.09.2018
 * Time: 12:02
 */

namespace frontend\modules\api\models;


class User extends \common\models\User
{

    public function fields()
    {
        return ['id', 'name' => 'username'];
    }

    public function extraFields()
    {
        return ['projects', 'projectsUsers'];
    }


}