<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 10.09.2018
 * Time: 16:09
 */

namespace frontend\modules\api\controllers;


use yii\rest\ActiveController;

class ProjectController extends ActiveController
{
    public $modelClass = 'frontend\modules\api\models\Project';
}