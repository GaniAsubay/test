<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%EVENT}}`.
 */
class m220322_134980_CREATE_EVENT_TABLE extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'date_created' => $this->timestamp(),
            'goal' => $this->string(255)->notNull(),
            'price' => $this->double()->notNull(),
            'supplier_id' => $this->integer(11)->notNull(),
            'status' => $this->tinyInteger(1)->notNull(),
        ]);
        $this->addForeignKey(
            'fk_event_supplier_event',
            '{{%event}}',
            'supplier_id',
            '{{%supplier}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%EVENT}}');
        $this->dropForeignKey('fk_event_supplier_event','{{%event}}');
    }
}
