<?php

use yii\db\Migration;

/**
 * Class m180905_011043_add_column_avatart_in_user
 */
class m180905_011043_add_column_avatart_in_user extends Migration
{

    const TABLE_NAME = 'user';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'avatar', $this->string()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'avatar');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_011043_add_column_avatart_in_user cannot be reverted.\n";

        return false;
    }
    */
}
