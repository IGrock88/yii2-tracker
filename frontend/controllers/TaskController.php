<?php

namespace frontend\controllers;

use common\models\Project;
use common\models\ProjectUser;
use common\models\query\TaskQuery;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
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
        /**@var  $query  TaskQuery      */
        $query->byUser(Yii::$app->user->id);

        $userProjects = Project::find()->byUser(Yii::$app->user->id)->select('title')->indexBy('id')->column();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userProjects' => $userProjects,
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
        $model->completed_at = null;

        if ($model->save()){
            Yii::$app->session->setFlash('success', 'Задача отправлена на доработку');
            $this->redirect('index');
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
        $userModel = Yii::$app->user->identity;

        Yii::$app->taskService->takeTask($taskModel, $userModel);

        if ($taskModel->save()){
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
        $userModel = Yii::$app->user->identity;

        Yii::$app->taskService->completeTask($taskModel, $userModel);

        if ($taskModel->save()){
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
