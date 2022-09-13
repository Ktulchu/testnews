<?php

use yii\db\Migration;

/**
 * Class m220913_115613_create_table_coment
 */
class m220913_115613_create_table_coment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%coments}}', [
            'id' => $this->primaryKey(),
			'id_article' => $this->integer(11)->notNull(),
			'user' => $this->string(100)->notNull(),		
            'coment' => $this->string(1000)->notNull(),
            'status' => $this->integer(2)->notNull(),
			'created_at' => $this->integer(11)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('{{%coments}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220913_115613_create_table_coment cannot be reverted.\n";

        return false;
    }
    */
}
