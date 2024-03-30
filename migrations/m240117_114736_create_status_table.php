<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m240117_114736_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
        ]);

        $this->insert('{{%status}}',
            [
                'code' => 'new',
                'name' => 'Новое',
            ]);

        $this->insert('{{%status}}',
            [
                'code' => 'approve',
                'name' => 'Подтверждено',
            ]
        );
        $this->insert('{{%status}}',
            [
                'code' => 'rejected',
                'name' => 'Отклонено',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
