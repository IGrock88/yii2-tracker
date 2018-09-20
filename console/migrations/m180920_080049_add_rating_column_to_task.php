<?php

use yii\db\Migration;

/**
 * Class m180920_080049_add_rating_column_to_task
 */
class m180920_080049_add_rating_column_to_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'rating', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task', 'rating');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180920_080049_add_rating_column_to_task cannot be reverted.\n";

        return false;
    }
    */
}
