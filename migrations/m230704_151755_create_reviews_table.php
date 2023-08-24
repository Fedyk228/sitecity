<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m230704_151755_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'id_city' => $this->integer(),
            'title' => $this->string(),
            'text' => $this->string(),
            'rating' => $this->integer(),
            'img' => $this->string(),
            'id_author' => $this->integer(),
            'date_create' => $this->string()
        ]);

        $this->addForeignKey('fk_city_id', 'reviews', 'id_city', 'citys', 'id');
        $this->addForeignKey('fk_author_id', 'reviews', 'id_author', 'authors', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_city_id');
        $this->dropForeignKey('fk_author_id');

        $this->dropTable('{{%reviews}}');
    }
}
