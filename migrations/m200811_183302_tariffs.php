<?php

use yii\db\Migration;

/**
 * Class m200811_183302_tariffs
 */
class m200811_183302_tariffs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return $this->createTable('{{%tariffs}}', [
            'id' => $this->primaryKey()->unsigned(),
            't1' => $this->money(5, 2)->notNull(),
            't2' => $this->money(5, 2)->notNull(),
            't3' => $this->money(5, 2)->notNull(),
            'col' => $this->money(5, 2)->notNull(),
            'hot' => $this->money(5, 2)->notNull(),
            'sewerage' => $this->money(5, 2)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropTable('{{%tariffs}}');
    }
}
