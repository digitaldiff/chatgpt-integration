<?php
namespace publishing\chatgptintegration\records;

use craft\db\ActiveRecord;

/**
 * @property int $id
 * @property string $label
 * @property string $promptTemplate
 * @property bool $enabled
 *
 * @property-read \yii\db\ActiveQueryInterface $element
 */
class ChatgptIntegration_PromptRecord extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%chatgptintegration_prompt}}';
    }
}