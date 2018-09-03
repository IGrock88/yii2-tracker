<?php

use yii\db\Migration;

/**
 * Class m180903_051342_add_active_column_into_project
 */
class m180903_051342_add_active_column_into_project extends Migration
{

    const TABLE_NAME = 'project';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'active',
            $this->boolean()->defaultValue(0)->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180903_051342_add_active_column_into_project cannot be reverted.\n";

        return false;
    }
    */
}
