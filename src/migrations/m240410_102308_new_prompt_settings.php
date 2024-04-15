<?php

namespace publishing\chatgptintegration\migrations;

use Craft;
use craft\db\Migration;
use publishing\chatgptintegration\records\ChatgptIntegration_PromptRecord;

/**
 * m240410_102308_new_prompt_settings migration.
 */
class m240410_102308_new_prompt_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        if (!$this->db->columnExists(ChatgptIntegration_PromptRecord::tableName(), 'temperature')) {
            $this->addColumn(ChatgptIntegration_PromptRecord::tableName(), 'temperature', $this->float()->defaultValue(1));
        }

        if (!$this->db->columnExists(ChatgptIntegration_PromptRecord::tableName(), 'frequencyPenalty')) {
            $this->addColumn(ChatgptIntegration_PromptRecord::tableName(), 'frequencyPenalty', $this->float()->defaultValue(0));
        }

        if (!$this->db->columnExists(ChatgptIntegration_PromptRecord::tableName(), 'presencePenalty')) {
            $this->addColumn(ChatgptIntegration_PromptRecord::tableName(), 'presencePenalty', $this->float()->defaultValue(0));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m240410_102308_new_prompt_settings cannot be reverted.\n";
        return false;
    }
}
