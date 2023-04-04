<?php

namespace publishing\chatgptintegration\models;

use craft\base\Model;
use craft\helpers\App;

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

    /**
     * @var int
     */
    public int $maxTokens = 256;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return App::parseEnv($this->accessToken);
    }
}