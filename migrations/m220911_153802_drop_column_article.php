<?php

use yii\db\Migration;

/**
 * Class m220911_153802_drop_column_article
 */
class m220911_153802_drop_column_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		 $this->dropColumn('article', 'article');
		 $this->addColumn('article', 'seourl', $this->string(500)->after('announcement')->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('article', 'article', $this->string(100)->notNull());
	    $this->dropColumn('article', 'seourl');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220911_153802_drop_column_article cannot be reverted.\n";

        return false;
    }
    */
}
