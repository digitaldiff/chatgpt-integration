<?php
namespace publishing\chatgptintegration\models;

use craft\base\Model;
use DateTime;

class PromptModel extends Model
{
    /**
     * @var int
     */
    public int $id = 0;

    /**
     * @var string
     */
    public string $label = '';

    /**
     * @var string
     */
    public string $promptTemplate = '';

    /**
     * @var bool
     */
    public bool $enabled = true;

    /**
     * @var DateTime
     */
    public DateTime $dateCreated;

    /**
     * @var DateTime
     */
    public DateTime $dateUpdated;

    /**
     * @var string
     */
    public string $uid;

    /**
     * @return DateTime
     */
    public function getDateCreated(): DateTime
    {
        if (!isset($this->dateCreated)) {
            $this->dateCreated = new DateTime('now');
        }
        return $this->dateCreated;
    }

    /**
     * @return DateTime
     */
    public function getDateUpdated(): DateTime
    {
        if (!isset($this->dateUpdated)) {
            $this->dateUpdated = new DateTime('now');
        }
        return $this->dateUpdated;
    }

    /**
     * @return array
     */
    public function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = [['label', 'promptTemplate'], 'required' ];

        return $rules;
    }
}