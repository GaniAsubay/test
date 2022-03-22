<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%SUPPLIER}}`.
 */
class m220322_134504_CREATE_SUPPLIER_TABLE extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey(),
            'endpoint' => $this->string(255)->notNull(),
            'request_type' => $this->tinyInteger(1)->notNull(),
            'parameters' => $this->string(255)->notNull(),
            'date_created' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%SUPPLIER}}');
    }
}
