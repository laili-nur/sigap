# SIGAP (WORK IN PROGRESS)
Sistem Informasi Penerbitan dan Percetakan Buku GAMA PRESS

Developed for UGM PRESS internal system

## Feature
- **PUBLISHING SYSTEM**
  - User Management
  - Draft Management
  - Book Management
  - Document Management
  - User Access Control
  - Versioning Draft / Track draft progress
- **PRINTING SYSTEM** (coming soon)
- **WAREHOUSE SYSTEM** (coming soon)

## System
- PHP - Codeigniter 3
- CSS - Bootstrap 4
- JS - Jquery
- Database - Mysql

## How to run
- Xammpp with PHP 7.3
- Install composer
- You can run PHP and composer on terminal
- Create `.env.development` from `.env.example` and fill those credentials
- Run local webserver and mysql
- Import sigap.sql database using phpmyadmin
- Run `composer install`

### Formatting Convention
- Install **'Format HTML in PHP'** & **'phpfmt'** plugin from vs code marketplace
- Add config below to setting.json in VS code

```json
    // Format HTML in PHP
    "editor.insertSpaces": true,
    "editor.tabSize": 3,
    "html.format.contentUnformatted": "pre,code,textarea",
    "html.format.endWithNewline": false,
    "html.format.extraLiners": "head, body, /html",
    "html.format.indentHandlebars": false,
    "html.format.indentInnerHtml": false,
    "html.format.maxPreserveNewLines": null,
    "html.format.preserveNewLines": true,
    "html.format.wrapLineLength": 120,
    "html.format.wrapAttributes": "force-expand-multiline",
    // phpfmt
    "intelephense.format.enable": false,
    "phpfmt.passes": [
        "PSR2KeywordsLowerCase",
        "PSR2LnAfterNamespace",
        "PSR2CurlyOpenNextLine",
        "PSR2ModifierVisibilityStaticOrder",
        "PSR2SingleEmptyLineAndStripClosingTag",
        "ReindentSwitchBlocks"
    ],
    "phpfmt.exclude": [
        "ReindentComments",
        "StripNewlineWithinClassBody"
    ],
    "phpfmt.enable_auto_align": true,
```
