<?php

use yii\db\Migration;

/**
 * Class m220909_123232_create_table_category
 */
class m220909_123232_create_table_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
			'parent_id' => $this->integer(11),
            'name' => $this->string(100)->notNull(),
            'seourl' => $this->string(100)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220909_123232_create_table_category cannot be reverted.\n";

        return false;
    }
    */
}
