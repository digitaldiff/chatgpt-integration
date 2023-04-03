<?php

namespace publishing\chatgptintegration\models;

use craft\base\Model;

/**
 * @var string $pluginName
 * @var string $accessToken
 * @var bool $usePageLang
 */
class SettingsModel extends Model
{
    /**
     * @var string
     */
    public string $pluginName = 'Chat GPT Integration';

    /**
     * @var string
     */
    public string $accessToken = '';

    /**
     * @var bool
     */
    public bool $usePageLang = true;

}