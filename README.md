# IFrame module

[![CI](https://github.com/silverstripe/silverstripe-iframe/actions/workflows/ci.yml/badge.svg)](https://github.com/silverstripe/silverstripe-iframe/actions/workflows/ci.yml)
[![Silverstripe supported module](https://img.shields.io/badge/silverstripe-supported-0071C4.svg)](https://www.silverstripe.org/software/addons/silverstripe-commercially-supported-module-list/)

## Introduction

The IFrame module provides an IFrame page type in the CMS which allows you to embed an IFrame into a page without
resorting to custom code in your templates or TinyMCE instance.
 
This can help if you have `iframe` disabled in TinyMCE's [valid_elements](https://www.tiny.cloud/docs-3x/reference/configuration/Configuration3x@valid_elements/)
and do not want to to re-enable it in for a single/specific use-case. It's also possible that using a Web Application
Firewall (WAF) may block page save requests that contain iframe elements in HTML content, which using this module would
circumvent.

Various attributes of the IFrame can be controlled from CMS fields, such as size and content that surrounds the
IFrame itself.

## Requirements

 * Silverstripe ^4.0

**Note:** For a Silverstripe 3.x compatible version, please use [the 1.x release line](https://github.com/silverstripe/silverstripe-iframe/tree/1.0).

## Installation

Install with Composer:

```
composer require silverstripe/iframe
```

After installation, ensure you run `dev/build?flush` in either your browser or via command line.

## Instructions

For usage instructions see the [user manual](docs/en/userguide/index.md).

## Contributing

### Translations

Translations of the natural language strings are managed through a third party translation interface, transifex.com. Newly added strings will be periodically uploaded there for translation, and any new translations will be merged back to the project source code.

Please use [https://www.transifex.com/projects/p/silverstripe-iframe](https://www.transifex.com/projects/p/silverstripe-iframe) to contribute translations, rather than sending pull requests with YAML files.
