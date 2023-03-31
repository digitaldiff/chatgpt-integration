<?php
namespace publishing\chatgptintegration\services;


use craft\elements\conditions\RelatedToConditionRule;
use craft\helpers\StringHelper;
use publishing\chatgptintegration\models\PromptModel;
use publishing\chatgptintegration\records\ChatgptIntegration_PromptRecord;
use yii\base\Component;

class PromptService extends Component
{
    /**
     * @return array
     */
    public function getPrompts(): array
    {
        $result = [];
        $prompts =  ChatgptIntegration_PromptRecord::find()->all();
        foreach($prompts as $prompt) {
            $result[] = $this->mapToModel($prompt);
        }

        return $result;
    }

    public function getPromptById(int $id): PromptModel
    {
        return $this->mapToModel(ChatgptIntegration_PromptRecord::find()->where(['id' => $id])->one());
    }

    /**
     * @param PromptModel $model
     * @return bool
     * @throws \Exception
     */
    public function savePrompt(PromptModel $model): bool
    {
        $record = new ChatgptIntegration_PromptRecord();

        $record->id = 0;
        $record->dateCreated = $model->getDateCreated();
        $record->dateUpdated = $model->getDateUpdated();
        $record->uid = StringHelper::UUID();

        $this->mapToRecord($model, $record);

        return $record->save();
    }

    public function deletePrompt(int $id): int
    {
        return ChatgptIntegration_PromptRecord::deleteAll(['id' => $id]);
    }

    protected function mapToModel(ChatgptIntegration_PromptRecord $record): PromptModel
    {
        $model = new PromptModel();
        $model->id = $record->id;
        $model->enabled = $record->enabled;
        $model->label = $record->label;
        $model->promptTemplate = $record->promptTemplate;
        $model->uid = $record->uid;
        $model->dateCreated = date_create_from_format('Y-m-d H:i:s', $record->dateCreated);
        $model->dateUpdated = date_create_from_format('Y-m-d H:i:s', $record->dateUpdated);

        return $model;
    }

    protected function mapToRecord(PromptModel $model, ChatgptIntegration_PromptRecord $record = null ): ChatgptIntegration_PromptRecord
    {
        if ($record === null){
            $record = new ChatgptIntegration_PromptRecord();
        }
        $record->id = $model->id;
        $record->dateUpdated = $model->dateUpdated;
        $record->dateCreated = $model->dateCreated;
        $record->enabled = $model->enabled;
        $record->label = $model->label;
        $record->promptTemplate = $model->promptTemplate;

        return $record;
    }
}