<?php

use yii\db\Migration;

/**
 * Class m180827_014708_create_project_user
 */
class m180827_014708_create_project_user extends Migration
{

    const TABLE_NAME = 'project_user';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => 'ENUM("manager", "developer", "tester")'
        ]);
    }

    /**
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
        echo "m180827_014708_create_project_user cannot be reverted.\n";

        return false;
    }
    */
}
