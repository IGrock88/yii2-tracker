<?php

use yii\db\Migration;

/**
 * Class m180903_052255_add_column_project_id_into_task
 */
class m180903_052255_add_column_project_id_into_task extends Migration
{

    const TABLE_NAME = 'task';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'project_id', $this->integer()->notNull()->after('estimation'));
        $this->addForeignKey('fx_task_project_id', self::TABLE_NAME, 'project_id', 'project', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_task_project_id', self::TABLE_NAME);
        $this->dropColumn(self::TABLE_NAME, 'project_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180903_052255_add_column_project_id_into_task cannot be reverted.\n";

        return false;
    }
    */
}
