<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 12.09.2018
 * Time: 11:53
 */

namespace common\services\events;

use common\models\Project;
use common\models\User;
use yii\base\Event;

class AssignRole extends Event
{
    /**
     * @property User $user
     * @property Project $project
     * @property $role string
     */
    private $user;
    private $project;
    private $role;

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }


}