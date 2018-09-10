<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 10.09.2018
 * Time: 12:04
 */

namespace frontend\modules\api\models;


class Project extends \common\models\Project
{

    public function fields()
    {
        return ['id', 'title'];
    }

    public function extraFields()
    {
        //return ['projectUsers'];
    }
}