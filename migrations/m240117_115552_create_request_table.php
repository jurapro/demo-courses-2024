<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%status}}`
 */
class m240117_115552_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'status_id' => $this->integer()->defaultValue(1),
            'auto_number' => $this->string()->notNull()->unique(),
            'text' => $this->text(),
            'created_at' => $this->dateTime(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-request-user_id}}',
            '{{%request}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `status_id`
        $this->createIndex(
            '{{%idx-request-status_id}}',
            '{{%request}}',
            'status_id'
        );

        // add foreign key for table `{{%status}}`
        $this->addForeignKey(
            '{{%fk-request-status_id}}',
            '{{%request}}',
            'status_id',
            '{{%status}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-request-user_id}}',
            '{{%request}}'
        );

        // drops foreign key for table `{{%status}}`
        $this->dropForeignKey(
            '{{%fk-request-status_id}}',
            '{{%request}}'
        );

        // drops index for column `status_id`
        $this->dropIndex(
            '{{%idx-request-status_id}}',
            '{{%request}}'
        );

        $this->dropTable('{{%request}}');
    }
}
