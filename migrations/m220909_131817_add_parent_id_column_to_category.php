<?php

use yii\db\Migration;

/**
 * Class m220909_131817_add_parent_id_column_to_category
 */
class m220909_131817_add_parent_id_column_to_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn('{{%category}}', 'parent_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220909_131817_add_parent_id_column_to_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220909_131817_add_parent_id_column_to_category cannot be reverted.\n";

        return false;
    }
    */
}
