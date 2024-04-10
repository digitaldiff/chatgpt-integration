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

    /**
     * @param bool $enabled
     * @return array
     */
    public function getPrompts(bool $enabled = false): array
    {
        return Plugin::getInstance()->promptService->getPrompts($enabled);
    }

    /**
     * @throws \ReflectionException
     */
    public function getClass($object)
    {
        return (new \ReflectionClass($object))->getName();
    }

    public function getFieldToTypeFieldMap()
    {
        $entryTypes = \Craft::$app->getEntries()->getAllEntryTypes();
        $typeFieldList = [];

        foreach ($entryTypes as $type) {
            foreach ($type->getFieldLayout()->getCustomFields() as $customField) {
                $typeFieldList[$customField->getId()][$type->id] = $type;
            }
        }

        return $typeFieldList;
    }
}