<?php
namespace publishing\chatgptintegration\models;

use craft\base\Model;

class PromptModel extends Model
{
    public int $id = 0;
    public string $label = '';
    public string $promptTemplate = '';
    public bool $enabled = true;
    public \DateTime $dateCreated;
    public \DateTime $dateUpdated;
    public string $uid;

    public function getDateCreated()
    {
        if (!isset($this->dateCreated))
            $this->dateCreated = new \DateTime('now');
        return $this->dateCreated;
    }

    public function getDateUpdated()
    {
        if (!isset($this->dateUpdated))
            $this->dateUpdated = new \DateTime('now');
        return $this->dateUpdated;
    }

    public function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = [['label', 'promptTemplate'], 'required' ];

        return $rules;
    }
}