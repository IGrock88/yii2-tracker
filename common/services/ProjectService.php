<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 11.09.2018
 * Time: 14:16
 */

namespace common\services;


use yii\base\Component;

class ProjectService extends Component
{

    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    public function assignRole($project, $user, $role)
    {
        $event = new AssignRoleEvent();
    }

}