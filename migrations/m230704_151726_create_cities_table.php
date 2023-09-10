<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%citys}}`.
 */
class m230704_151726_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cities}}', [
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
        $this->dropTable('{{%cities}}');
    }
}
