<?php
namespace publishing\chatgptintegration\migrations;

use Craft;
use craft\db\Migration;
use craft\helpers\StringHelper;
use publishing\chatgptintegration\records\ChatgptIntegration_PromptRecord;

/**
 * Install migration.
 */
class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->createTables();
        $this->insertDefaultRows();
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->removeTables();

        return true;
    }

    protected function createTables(): void
    {

        $this->archiveTableIfExists(ChatgptIntegration_PromptRecord::tableName());
        $this->createTable(ChatgptIntegration_PromptRecord::tableName(), [
            'id' => $this->primaryKey(),
            'label' => $this->string()->notNull(),
            'promptTemplate' => $this->string()->notNull(),
            'enabled' => $this->boolean()->notNull()->defaultValue(true),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
        ]);
    }

    protected function insertDefaultRows() {
        $this->insert(ChatgptIntegration_PromptRecord::tableName(), array(
            'label' => 'Shorten',
            'promptTemplate' => 'Shorten the following text:'
        ));

        $this->insert(ChatgptIntegration_PromptRecord::tableName(), array(
            'label' => 'Fix the grammar',
            'promptTemplate' => 'Fix the grammar:'
        ));

        $this->insert(ChatgptIntegration_PromptRecord::tableName(), array(
            'label' => 'Rewrite',
            'promptTemplate' => 'Rewrite the following text:'
        ));
    }

    protected function removeTables()
    {
        $tables = [
            ChatgptIntegration_PromptRecord::tableName()
        ];
        foreach ($tables as $table) {
            $this->dropTableIfExists($table);
        }
    }
}
