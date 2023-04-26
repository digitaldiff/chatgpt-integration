<?php

namespace publishing\chatgptintegration\controllers;

use publishing\chatgptintegration\Plugin;
use yii\web\Response;

class SettingsController extends \craft\web\Controller
{
    /**
     * @return Response
     */
    public function actionGeneral(): Response
    {
        $settings = Plugin::getInstance()->getSettings();

        return $this->renderTemplate('chatgpt-integration/settings/general', [
            'settings' => $settings,
        ]);
    }

    /**
     * @return Response
     */
    public function actionApi(): Response
    {
        $settings = Plugin::getInstance()->getSettings();

        return $this->renderTemplate('chatgpt-integration/settings/api', [
            'settings' => $settings,
        ]);
    }

    /**
     * @return Response
     */
    public function actionFields(): Response
    {
        $settings = Plugin::getInstance()->getSettings();

        return $this->renderTemplate('chatgpt-integration/settings/fields', [
            'settings' => $settings,
        ]);
    }
}