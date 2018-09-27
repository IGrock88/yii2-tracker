<?php

namespace frontend\controllers;

use common\models\Project;
use common\models\ProjectUser;
use common\models\query\TaskQuery;
use common\models\User;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\base\Theme;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{

    const ASSES_DENIED_MESSAGE = 'Доступ запрещён, обратитесь к администратору';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            $userRoles = Yii::$app->projectService->getAllUserRoles(Yii::$app->user->identity);
                            if ($userRoles) {
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['update', 'redo', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            $project = Task::findOne(Yii::$app->request->get('id'))->project;
                            $user = Yii::$app->user->identity;
                            $hasRole = Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
                            if ($hasRole) {
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            $user = Yii::$app->user->identity;
                            $hasRole = Yii::$app->projectService->hasRolesAllProject($user, ProjectUser::ROLE_MANAGER);
                            if ($hasRole) {
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['take', 'complete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            $project = Task::findOne(Yii::$app->request->get('id'))->project;
                            $user = Yii::$app->user->identity;
                            $hasRole = Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_DEVELOPER);
                            if ($hasRole) {
                                return true;
                            }
                            return false;
                         }
                    ],
                ],
                'denyCallback' => function(){
                    throw new ForbiddenHttpException(self::ASSES_DENIED_MESSAGE);
                }

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = $dataProvider->query;
        /**@var  $query  TaskQuery */
        $query->byUser(Yii::$app->user->id);

        $userProjects = Project::find()->byUser(Yii::$app->user->id)->select('title')->indexBy('id')->column();

        $projectDevelopers = Yii::$app
            ->projectService->getProjectsActiveUsersByRole(Yii::$app->user->identity, ProjectUser::ROLE_DEVELOPER);

        $projectManagers = Yii::$app
            ->projectService->getProjectsActiveUsersByRole(Yii::$app->user->identity, ProjectUser::ROLE_MANAGER);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userProjects' => $userProjects,
            'projectManagers' => $projectManagers,
            'projectDevelopers' => $projectDevelopers,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRedo($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->taskService->isComplete($model)) {
            Yii::$app->session->setFlash('danger', 'Задача ' . $id . ' ещё не выполнена');
            return $this->redirect('index');
        }

        $model->completed_at = null;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Задача отправлена на доработку');
            return $this->redirect('index');
        }
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $projects = Project::find()->byUser(Yii::$app->user->id, ProjectUser::ROLE_MANAGER)
            ->select('title')->indexBy('id')->column();

        return $this->render('create', [
            'model' => $model,
            'projects' => $projects
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->setScenario(Task::SCENARIO_UPDATE);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $projects = Project::find()->byUser(Yii::$app->user->id, ProjectUser::ROLE_MANAGER)
            ->select('title')->indexBy('id')->column();
        return $this->render('update', [
            'model' => $model,
            'projects' => $projects
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Take task to work
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTake($id)
    {
        $taskModel = $this->findModel($id);
        $currentUser = Yii::$app->user->identity;

        if (!Yii::$app->taskService->canTake($taskModel, $currentUser)) {
            Yii::$app->session
                ->setFlash('danger', 'Задача c id ' . $id . ' уже взята в работу либо у вас остутствует доступ');
            return $this->redirect(['index']);
        }

        Yii::$app->taskService->takeTask($taskModel, $currentUser);

        if ($taskModel->save()) {
            $estimationDate = Yii::$app->formatter->asDatetime($taskModel->estimation);
            Yii::$app->session
                ->setFlash('success',
                    'Задача успешно взята, необходимо выполнить задачу до ' . $estimationDate);

        }
        return $this->redirect(['view', 'id' => $id]);
    }


    /**
     * Complete task
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionComplete($id)
    {
        $taskModel = $this->findModel($id);
        $currentUser = Yii::$app->user->identity;

        if (!Yii::$app->taskService->canComplete($taskModel, $currentUser)) {
            Yii::$app->session
                ->setFlash('danger', 'Задача c id ' . $id . ' уже выполнена либо у вас остутствует доступ');
            return $this->redirect(['index']);
        }

        Yii::$app->taskService->completeTask($taskModel, $currentUser);

        if ($taskModel->save()) {
            Yii::$app->session
                ->setFlash('success',
                    'Задача помечена как выполненная');

        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
