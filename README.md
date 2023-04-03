# ChatGPT Integration

The plugin adds a dropdown to every text field, as well as textarea and redactor.

With this functionality, text can be automatically corrected, translated, shortened and created. And of course many other functions can be added individually. There are almost no limits.

The texts are directly forwarded to ChatGPT with the respective command. The commands can be entered globally in the settings.

For the plugin to work, an OpenAI ( https://openai.com/ ) account is required and an API key must be created.
https://platform.openai.com/account/api-keys

There may be additional costs on the part of OpenAI.

## Requirements

This plugin requires Craft CMS 4.4.3 or later, and PHP 8.0.2 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “chatgpt-integration”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require 3w-publishing/craft-chatgpt-integration

# tell Craft to install the plugin
./craft plugin/install chatgpt-integration
```
