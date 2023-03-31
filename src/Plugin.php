<?php

namespace publishing\chatgptintegration;

use Craft;
use craft\base\Field;
use craft\events\DefineFieldHtmlEvent;
use craft\events\DefineHtmlEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\StringHelper;
use craft\helpers\UrlHelper;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use publishing\chatgptintegration\models\SettingsModel;
use publishing\chatgptintegration\services\PromptService;
use publishing\chatgptintegration\variables\ChatgptIntegrationVariable;
use yii\base\Event;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use craft\elements\Entry;

/**
 * chatgpt-integration plugin
 *
 * @author 3w-publishing <support@3w-publishing.ch>
 * @copyright 3w-publishing
 * @license https://craftcms.github.io/license/ Craft License
 *
 * @property PromptService $promptService;
 * @property-read null|array $cpNavItem
 * @property-read string $pluginName
 * @property-read mixed $settingsResponse
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;
    public bool $hasCpSection = true;

    public static function config(): array
    {
        return [
            'components' => [
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->setup();
            $this->attachFunctions();
            $this->registerEvents();
        });

    }

    protected function setup(): void {
        $this->setComponents([
            'promptService' => PromptService::class,
        ]);
    }

    protected function createSettingsModel(): ?Model
    {
        return new SettingsModel();

    }

    protected function settingsHtml(): ?string
    {
        return \Craft::$app->getView()->renderTemplate(
            'chatgpt-integration/settings',
            [ 'settings' => $this->getSettings() ]
        );
    }

    private function attachFunctions(): void
    {
        Event::on(
            Field::class,
            Field::EVENT_DEFINE_INPUT_HTML,
            static function (DefineFieldHtmlEvent $event) {
                $event->html .= Craft::$app->view->renderTemplate('chatgpt-integration/form.twig', ['input' => $event->html, 'hash' => StringHelper::UUID() ] );
            }
        );
        Event::on(
            Entry::class,
            Entry::EVENT_DEFINE_SIDEBAR_HTML,
            static function (DefineHtmlEvent  $event) {
                $event->html .= Craft::$app->view->renderTemplate('chatgpt-integration/functions.twig');
            }
        );
    }

    protected function registerEvents(): void
    {
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            static function (RegisterUrlRulesEvent $event) {
                // Field Layouts
                $event->rules['chatgpt-integration/prompts/new'] = 'chatgpt-integration/prompt/create-prompt';
                $event->rules['chatgpt-integration/prompts/edit/<id:\d+>'] = 'chatgpt-integration/prompt/edit-prompt';
                $event->rules['chatgpt-integration/prompts/delete/<id:\d+>'] = 'chatgpt-integration/prompt/delete-prompt';

                $event->rules['chatgpt-integration/settings/general'] = 'chatgpt-integration/settings/settings';
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('chatgptIntegration', ChatgptIntegrationVariable::class);
            }
        );
    }


    public function getPluginName(): string
    {
        return $this->getSettings()->pluginName;
    }

    public function getCpNavItem(): ?array
    {
        $nav = parent::getCpNavItem();

        $nav['label'] = \Craft::t('chatgpt-integration', $this->getPluginName());
        $nav['url'] = 'chatgpt-integration';

        $nav['subnav']['prompts'] = [
            'label' => Craft::t('chatgpt-integration', 'Prompts'),
            'url' => 'chatgpt-integration/prompts',
        ];

        if (Craft::$app->getUser()->getIsAdmin()) {
            $nav['subnav']['settings'] = [
                'label' => Craft::t('chatgpt-integration', 'Settings'),
                'url' => 'chatgpt-integration/settings',
            ];
        }

        return $nav;
    }

    public function getSettingsResponse(): mixed
    {
        return Craft::$app->controller->redirect(UrlHelper::cpUrl('chatgpt-integration/settings'));
    }
}
