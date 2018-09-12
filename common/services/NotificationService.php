<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 12.09.2018
 * Time: 15:41
 */

namespace common\services;


use common\services\events\AssignRole;

class NotificationService
{

    /**
     * @param AssignRole $event
     */
    public function sendChangeRoleEmail(AssignRole $event)
    {
        $views = ['html' => 'assignRoleEmailToProject-html', 'text' => 'assignRoleEmailToProject-text'];
        $data = ['project' => $event->getProject(), 'user' => $event->getUser(), 'role' => $event->getRole()];
        \Yii::$app->emailService->send('New role', $views, $data);
    }
}