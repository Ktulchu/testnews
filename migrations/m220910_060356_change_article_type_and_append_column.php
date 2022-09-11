<?php

use yii\db\Migration;

/**
 * Class m220910_060356_change_article_type_and_append_column
 */
class m220910_060356_change_article_type_and_append_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->alterColumn('article', 'article', $this->string(100)->notNull());
		$this->addColumn('article', 'content', $this->text()->after('announcement')->notNull());
		$this->addColumn('article', 'image', $this->string(255)->after('category_id'));
		$this->addColumn('article', 'public_date', $this->string(255)->after('article'));
		$this->addColumn('article', 'ext_id', $this->string(255)->after('article'));	
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220910_060356_change_article_type_and_append_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220910_060356_change_article_type_and_append_column cannot be reverted.\n";

        return false;
    }
    */
}
