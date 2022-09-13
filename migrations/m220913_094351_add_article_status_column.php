<?php

use yii\db\Migration;

/**
 * Class m220913_094351_add_article_status_column
 */
class m220913_094351_add_article_status_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		 $this->addColumn('article', 'status', $this->integer()->notNull()->defaultValue(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('article', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220913_094351_add_article_status_column cannot be reverted.\n";

        return false;
    }
    */
}
