<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $estimation
 * @property int $project_id
 * @property int $executor_id
 * @property int $started_at
 * @property int $completed_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 * @property int $rating
 *
 * @property User $executor
 * @property User $creator
 * @property User $updater
 *
 * @property Project $project
 */
class Task extends \yii\db\ActiveRecord
{

    const SCENARIO_UPDATE = 'task_update';
    const RELATION_PROJECT = 'project';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'estimation','project'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'project_id'], 'integer'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5, 'on' => self::SCENARIO_UPDATE],
            [['title'], 'string', 'max' => 255],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID задачи',
            'title' => 'Название задачи',
            'description' => 'Описание задачи',
            'estimation' => 'Сделать до',
            'executor_id' => 'Executor ID',
            'started_at' => 'Начало выполнения',
            'completed_at' => 'Время завершения',
            'created_by' => 'Кем создан',
            'updated_by' => 'Кем изменен',
            'created_at' => 'Время создания',
            'updated_at' => 'Время изменения',
            'rating' => 'Оценка задачи'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TaskQuery(get_called_class());
    }
}
