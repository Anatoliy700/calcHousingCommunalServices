<?php

use yii\db\Migration;

/**
 * Class m200813_105730_meters_data
 */
class m200813_105730_meters_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return $this->createTable('{{%meters_data}}', [
            'id' => $this->primaryKey()->unsigned(),
            't1' => $this->integer()->notNull(),
            't2' => $this->integer()->notNull(),
            't3' => $this->integer()->notNull(),
            'col' => $this->integer()->notNull(),
            'hot' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropTable('{{%meters_data}}');
    }
}
