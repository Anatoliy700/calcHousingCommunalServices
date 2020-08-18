<?php

use yii\db\Migration;

/**
 * Class m200813_161744_calc_result
 */
class m200813_161744_calc_result extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): bool
    {
        $this->createTable('{{%calc_result}}', [
            'id' => $this->primaryKey(),
            'current_meters_id' => $this->integer()->notNull(),
            'previous_meters_id' => $this->integer()->notNull(),
            'tariff_id' => $this->integer()->notNull(),
            'settlement_month' => $this->date()->notNull(),
            'total' => $this->money(19, 2)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'FOREIGN KEY (current_meters_id) REFERENCES {{%meters_data}}(id) ON UPDATE CASCADE ON DELETE CASCADE',
            'FOREIGN KEY (previous_meters_id) REFERENCES {{%meters_data}}(id) ON UPDATE RESTRICT ON DELETE RESTRICT',
            'FOREIGN KEY (tariff_id) REFERENCES {{%tariffs}}(id) ON UPDATE RESTRICT ON DELETE RESTRICT',
        ]);

        $this->createIndex(
            'curr_prev_meters_uk',
            '{{%calc_result}}',
            ['current_meters_id', 'previous_meters_id'],
            true
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool
    {
        $this->dropIndex('curr_prev_meters_uk', '{{%calc_result}}');
        $this->dropTable('{{%calc_result}}');

        return true;
    }
}
