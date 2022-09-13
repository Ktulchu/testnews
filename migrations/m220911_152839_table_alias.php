<?php

use yii\db\Migration;

/**
 * Class m220911_152839_table_alias
 */
class m220911_152839_table_alias extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%alias}}', [
            'id' => $this->primaryKey(),
            'seourl' => $this->string(500)->notNull()->unique(),
            'url' => $this->string(505)->notNull(),
            'safe' => $this->string(250)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%alias}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220911_152839_table_alias cannot be reverted.\n";

        return false;
    }
    */
}
