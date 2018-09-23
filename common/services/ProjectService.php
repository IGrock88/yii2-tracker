<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 11.09.2018
 * Time: 14:16
 */

namespace common\services;


use common\models\Project;
use common\models\ProjectUser;
use common\models\User;
use common\services\events\AssignRole;
use yii\base\Component;
use yii\base\Theme;

class ProjectService extends Component
{

    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRole();
        $event->setProject($project);
        $event->setUser($user);
        $event->setRole($role);
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }

    public function getRoles(Project $project, User $user)
    {
        return $project->getProjectUsers()->byUser($user->id)->select('role')->column();
    }

    public function getAllUserRoles(User $user)
    {
        return ProjectUser::find()->byUser($user->id)->select('role')->column();
    }

    public function hasRole(Project $project, User $user, $role)
    {
        return in_array($role, $this->getRoles($project, $user));
    }

    public function hasRolesAllProject(User $user, $role)
    {
        return in_array($role, ProjectUser::find()->byUser($user->id, $role)->select('role')->column());
    }

    public function canManage(Project $project, User $user)
    {
        return $this->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
    }

}