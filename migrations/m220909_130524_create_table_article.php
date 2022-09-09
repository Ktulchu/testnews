<?php

use yii\db\Migration;

/**
 * Class m220909_130524_create_table_article
 */
class m220909_130524_create_table_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->string(32)->notNull(),
            'title' => $this->string(32)->notNull(),
            'announcement' => $this->string(100)->notNull(),
            'article' => $this->string(100)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220909_130524_create_table_article cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220909_130524_create_table_article cannot be reverted.\n";

        return false;
    }
    */
}
