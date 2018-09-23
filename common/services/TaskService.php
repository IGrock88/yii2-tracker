<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 19.09.2018
 * Time: 9:16
 */

namespace common\services;


use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use Yii;

class TaskService
{

    public function canTake(Task $task, User $user)
    {
        $isDeveloper = Yii::$app->projectService
            ->hasRole($task->project, $user, ProjectUser::ROLE_DEVELOPER);

        return $isDeveloper && empty($task->executor_id);
    }

    public function canComplete(Task $task, User $user)
    {
        return $task->executor_id === $user->id && empty($task->completed_at);
    }

    public function takeTask(Task $task, User $user)
    {
        if ($this->canTake($task, $user)){
            $task->started_at = time();
            $task->executor_id = $user->id;

        }
        return $task;
    }

    public function completeTask(Task $task, User $user)
    {
        if ($this->canComplete($task, $user)){
            $task->completed_at = time();
        }
    }

    public function isComplete(Task $task)
    {
        return !empty($task->completed_at) && !empty($task->started_at);
    }

}