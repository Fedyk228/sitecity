<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%citys}}`.
 */
class m230704_151726_create_citys_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%citys}}', [
            'cid' => $this->primaryKey(),
            'name' => $this->string(),
            'date_create' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%citys}}');
    }
}
