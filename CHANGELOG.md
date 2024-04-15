# Release Notes for chatgpt-integration

## 4.0.6 - 2024-04-15

### Added 
- We now support CKEditor-fields.

### Changed
- Changed versioning to reflect the compatible craft version.
- Updated API settings:
    - The language model is now adjustable.
- Updated prompt settings:
    - "Temperature" is now adjustable.
    - "Frequency Penalty" is now adjustable.
    - "Presence Penalty" is now adjustable.

## 1.0.5 - 2024-03-20
### Changed
- Transfer ownership of plugin

## 1.0.4 - 2023-09-26
### Added
- Added the option to enable or disable individual fields inside matrix fields.

### Fixed
- Fixed an issue where an error could occur upon creating new fields. (#5)

## 1.0.3 - 2023-04-27
> {warning} Once you have installed the update, you need to head to the settings page and select which fields the prompts should be displayed for.

### Added
- Added the option to enable or disable individual fields in the settings.
- Added the option to disable the default translation prompts.
- Added warning when saving settings without an api token.

### Changed
- Divided settings over three sup-pages for clarity.

## 1.0.2 - 2023-04-04

### Added
- Added option to set the "max_tokens" request attribute value in the plugin settings.
- Now displays a warning if the ChatGPT output is incomplete due to the "max_tokens" restriction.  

### Changed
- Lowered required craft version to 4.0.0

## 1.0.1 - 2023-04-04

### Added
- Environment variable support for api key.
- Added button to matrix fields.
- Added button to Neo plugin fields.

### Changed
- Updated code structure for improved readability.

### Fixed
- Removed unused javascript.
- Fixed localization feature for non-multisites.

## 1.0.0 - 2023-04-03
- Initial release.
