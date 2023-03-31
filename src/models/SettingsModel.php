<?php

namespace publishing\chatgptintegration\models;

use craft\base\Model;

/**
 * @var string $pluginName
 * @var string $accessToken
 */
class SettingsModel extends Model
{
    /**
     * @var string
     */
    public string $pluginName = 'Chat GPT Integration';


    public string $accessToken = '';

}