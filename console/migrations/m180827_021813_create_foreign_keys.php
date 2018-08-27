<?php

use yii\db\Migration;

/**
 * Class m180827_021813_create_foreign_keys
 */
class m180827_021813_create_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_task_user1', 'task', ['executor_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_user2', 'task', ['created_by'], 'user', ['id']);
        $this->addForeignKey('fx_task_user3', 'task', ['updated_by'], 'user', ['id']);

        $this->addForeignKey('fx_project_user1', 'project', ['created_by'], 'user', ['id']);
        $this->addForeignKey('fx_project_user2', 'project', ['updated_by'], 'user', ['id']);

        $this->addForeignKey('fx_project_user_user', 'project_user', ['user_id'], 'user', ['id']);
        $this->addForeignKey('fx_project_user_project', 'project_user', ['project_id'], 'project', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_task_user1', 'task');
        $this->dropForeignKey('fx_task_user2', 'task');
        $this->dropForeignKey('fx_task_user3', 'task');

        $this->dropForeignKey('fx_project_user1', 'project');
        $this->dropForeignKey('fx_project_user2', 'project');

        $this->dropForeignKey('fx_project_user_user', 'project_user');
        $this->dropForeignKey('fx_project_user_project', 'project_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_021813_create_foreign_keys cannot be reverted.\n";

        return false;
    }
    */
}
