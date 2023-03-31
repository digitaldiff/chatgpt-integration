<?php

namespace publishing\chatgptintegration\controllers;

use publishing\chatgptintegration\models\PromptModel;
use publishing\chatgptintegration\Plugin;
use publishing\chatgptintegration\records\ChatgptIntegration_PromptRecord;
use yii\web\Response;

class PromptController extends \craft\web\Controller
{
    public function actionCreatePrompt(): Response
    {
        return $this->renderTemplate('chatgpt-integration/prompts/_new', ['prompt' => new PromptModel()]);
    }

    /**
     * @return Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionSavePrompt(): Response
    {
        $request = \Craft::$app->getRequest();

        $promptModel = new PromptModel();
        $promptModel->id = 0;
        $promptModel->label = $request->getRequiredParam('label');
        $promptModel->promptTemplate = $request->getRequiredParam('promptTemplate');
        $promptModel->enabled = $request->getRequiredParam('enabled');

        if (!$promptModel->validate()) {
            return $this->renderTemplate('chatgpt-integration/prompts/_edit', ['prompt' => $promptModel]);
        }

        if (Plugin::getInstance()->promptService->savePrompt($promptModel)) {
            return $this->redirect('chatgpt-integration/prompts');
        }

        return $this->renderTemplate('chatgpt-integration/prompts/_edit', ['prompt' => $promptModel]);


    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionEditPrompt(int $id): Response
    {
        $prompt = Plugin::getInstance()->promptService->getPromptById($id);
        return $this->renderTemplate('chatgpt-integration/prompts/_edit', ['prompt' => $prompt]);
    }

    /**
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionUpdatePrompt()
    {
        $request = \Craft::$app->getRequest();

        /** @var ChatgptIntegration_PromptRecord $record */
        $record = ChatgptIntegration_PromptRecord::find()->where(['id' => $request->getRequiredParam('id')])->one();

        $record->label = $request->getRequiredParam('label');
        $record->promptTemplate = $request->getRequiredParam('promptTemplate');
        $record->enabled = $request->getRequiredParam('enabled');

        $record->update();

    }

    /**
     * @return mixed
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionDeletePrompt($id)
    {
        $record = Plugin::getInstance()->promptService->deletePrompt($id);
        return $this->redirect('chatgpt-integration/prompts');
    }


    protected function mapModelToRecord(PromptModel $model, ChatgptIntegration_PromptRecord $record): void
    {
        $record->label = $model->label;
        $record->promptTemplate = $model->promptTemplate;
        $record->enabled = $model->enabled;
    }
}