<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 12.09.2018
 * Time: 15:41
 */

namespace common\services;


use common\models\Project;
use common\models\User;
use common\services\events\AssignRole;

class NotificationService
{

    /**
     * @param AssignRole $event
     */
    public function sendChangeRoleEmail(User $user, Project $project, $role)
    {
        $views = ['html' => 'assignRoleEmailToProject-html', 'text' => 'assignRoleEmailToProject-text'];
        $data = ['project' => $project, 'user' => $user, 'role' => $role];
        \Yii::$app->emailService->send('New role', $views, $data);
    }
}