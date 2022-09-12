<?php

use yii\db\Migration;

/**
 * Class m220909_074006_init
 */
class m220909_074006_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(100)->notNull(),
            'password_reset_token' => $this->string(100)->unique(),
            'email' => $this->string(250)->notNull()->unique(),
			'role' => $this->integer(2)->notNull()->defaultValue(10),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);
		
		$this->insert('{{%user}}',[
			'username'=>'admin',
			'auth_key'=>'2nUW-Jf-uxOC7OcOnxAyM7zqE6x5hzo8',
			'password_hash'=>'$2y$13$P9QioTsezdVZN1HCY3aaCefe/yAGWGpI7rwX4ezAWmfrwBpDh599O',
			'email' => 'admin@admin.ru',
			'role' => 20,
			'status' => 10,
			'created_at' => time(),
			'updated_at' => time(),
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220909_074006_init cannot be reverted.\n";

        return false;
    }
    */
}
