<?php
namespace publishing\chatgptintegration\variables;

use publishing\chatgptintegration\Plugin;

class ChatgptIntegrationVariable
{
    /**
     * @return string
     */
    public function getPluginName(): string
    {
        return Plugin::getInstance()->getSettings()->pluginName;
    }

    public function getPrompts(bool $enabled = false): array
    {
        return Plugin::getInstance()->promptService->getPrompts($enabled);
    }
}