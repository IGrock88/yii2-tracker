<?php

use yii\db\Migration;

/**
 * Class m180827_011152_create_task
 */
class m180827_011152_create_task extends Migration
{

    const TABLE_NAME = 'task';
    /**Create task table in datebase
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'estimation' => $this->timestamp()->notNull(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()
        ]);

    }

    /**Drop task table in database
     *
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_011152_create_task cannot be reverted.\n";

        return false;
    }
    */
}
