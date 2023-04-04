<?php

namespace publishing\chatgptintegration\controllers;

use craft\web\Controller;
use publishing\chatgptintegration\models\PromptModel;
use publishing\chatgptintegration\Plugin;
use yii\web\Response;

class PromptController extends Controller
{
    /**
     * @return Response
     */
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
            return $this->renderTemplate('chatgpt-integration/prompts/_new', ['prompt' => $promptModel]);
        }

        if (Plugin::getInstance()->promptService->savePrompt($promptModel)) {
            return $this->redirect('chatgpt-integration/prompts');
        }

        return $this->renderTemplate('chatgpt-integration/prompts/_new', ['prompt' => $promptModel]);
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
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionUpdatePrompt()
    {
        $request = \Craft::$app->getRequest();
        $model = new PromptModel;

        $model->id = $request->getRequiredParam('id');
        $model->label = $request->getRequiredParam('label');
        $model->promptTemplate = $request->getRequiredParam('promptTemplate');
        $model->enabled = $request->getRequiredParam('enabled');

        if (!$model->validate()) {
            return $this->renderTemplate('chatgpt-integration/prompts/_edit', ['prompt' => $model]);
        }

        Plugin::getInstance()->promptService->updatePrompt($model);

        return $this->redirect('chatgpt-integration/prompts');
    }

    /**
     * @return mixed
     */
    public function actionDeletePrompt($id)
    {
        $record = Plugin::getInstance()->promptService->deletePrompt($id);
        return $this->redirect('chatgpt-integration/prompts');
    }
}