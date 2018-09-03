<?php
namespace frontend\controllers;

use common\models\Project;
use common\models\Task;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Hello controller
 */
class HelloController extends Controller
{

    /**
     * Displays hello world page
     *
     * {@inheritdoc}
     */
    public function actionIndex()
    {
        $result = Task::find()->joinWith(Task::RELATION_PROJECT)->all();
        return $this->render('index', ['result' => $result]);
    }


}
