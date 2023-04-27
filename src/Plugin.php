<?php

namespace publishing\chatgptintegration;

use Craft;
use craft\base\Field;
use craft\events\DefineFieldHtmlEvent;
use craft\events\DefineHtmlEvent;
use craft\events\ModelEvent;
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
    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    /**
     * @var bool
     */
    public bool $hasCpSection = true;

    /**
     * @return array[]
     */
    public static function config(): array
    {
        return [
            'components' => [
            ],
        ];
    }

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setup();
        $this->attachFunctions();
        $this->registerEvents();
    }

    /**
     * @return void
     */
    protected function setup(): void {
        $this->setComponents([
            'promptService' => PromptService::class,
        ]);
    }

    /**
     * @return Model|null
     */
    protected function createSettingsModel(): ?Model
    {
        return new SettingsModel();
    }

    /**
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    protected function settingsHtml(): ?string
    {
        return \Craft::$app->getView()->renderTemplate(
            'chatgpt-integration/settings',
            [ 'settings' => $this->getSettings() ]
        );
    }

    /**
     * @return void
     */
    private function attachFunctions(): void
    {
        /**
         * Attach button to selected fields.
         */
        Event::on(
            Field::class,
            Field::EVENT_DEFINE_INPUT_HTML,
            static function (DefineFieldHtmlEvent $event) {
                /** @var SettingsModel $settings */
                $settings = Plugin::getInstance()->getSettings();

                if (array_key_exists($event->sender->id, $settings->enabledFields) && $settings->enabledFields[$event->sender->id]){
                    $event->html .= Craft::$app->view->renderTemplate('chatgpt-integration/form.twig', [ 'event' => $event, 'hash' => StringHelper::UUID()] );
                }
            }
        );

        /**
         * Warn user in case there are no selected fields.
         */
        Event::on(
            Plugin::class,
            Plugin::EVENT_AFTER_SAVE_SETTINGS,
            function (Event $event) {

                /** @var SettingsModel $settings */
                $settings = Plugin::getInstance()->getSettings();

                if (!in_array(true, $settings->enabledFields, false)){
                    Craft::$app->getSession()->setError('ChatGPT-Integration currently has no fields to attach to!');
                }

                if ($settings->accessToken === ''){
                    Craft::$app->getSession()->setError('API Access Token required .');
                }
            }
        );

        /**
         * Load twig with js code.
         */
        Event::on(
            Entry::class,
            Entry::EVENT_DEFINE_SIDEBAR_HTML,
            static function (DefineHtmlEvent  $event) {
                $event->html .= Craft::$app->view->renderTemplate('chatgpt-integration/functions.twig');
            }
        );
    }

    /**
     * @return void
     */
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

                $event->rules['chatgpt-integration/settings/general'] = 'chatgpt-integration/settings/general';
                $event->rules['chatgpt-integration/settings/api'] = 'chatgpt-integration/settings/api';
                $event->rules['chatgpt-integration/settings/fields'] = 'chatgpt-integration/settings/fields';
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

    /**
     * @return string
     */
    public function getPluginName(): string
    {
        return $this->getSettings()->pluginName;
    }

    /**
     * @return array|null
     */
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

    /**
     * @return mixed
     */
    public function getSettingsResponse(): mixed
    {
        return Craft::$app->controller->redirect(UrlHelper::cpUrl('chatgpt-integration/settings'));
    }
}
