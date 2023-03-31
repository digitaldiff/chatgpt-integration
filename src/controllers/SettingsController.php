<?php

namespace publishing\chatgptintegration\controllers;

use publishing\chatgptintegration\Plugin;
use yii\web\Response;

class SettingsController extends \craft\web\Controller
{
    public function actionSettings(): Response
    {
        $settings = Plugin::getInstance()->getSettings();

        return $this->renderTemplate('chatgpt-integration/settings/general', [
            'settings' => $settings,
        ]);
    }
}