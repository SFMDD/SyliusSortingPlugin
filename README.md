<p align="center">
    <a href="https://fm2d.com/" target="_blank">
        <img height="50" width="auto" src="https://fm2d.com/fm2d-theme/images/logo.png" alt="FM2D logo" />
        <img height="50" width="auto" src="https://demo.sylius.com/assets/shop/img/logo.png" alt="Sylius logo" />
    </a>
</p>

---
<h1 align="center">FM2D - SyliusSortingPlugin</h1>

---
[![License](http://poser.pugx.org/fmdd/sylius-sorting-plugin/license)](https://packagist.org/packages/fmdd/sylius-sorting-plugin)
[![Latest Stable Version](http://poser.pugx.org/fmdd/sylius-sorting-plugin/v)](https://packagist.org/packages/fmdd/sylius-sorting-plugin)
[![Total Downloads](http://poser.pugx.org/fmdd/sylius-sorting-plugin/downloads)](https://packagist.org/packages/fmdd/sylius-sorting-plugin)
[![PHP Version Require](http://poser.pugx.org/fmdd/sylius-sorting-plugin/require/php)](https://packagist.org/packages/fmdd/sylius-sorting-plugin)
[![Slack](https://img.shields.io/badge/community%20chat-slack-FF1493.svg)](http://sylius-devs.slack.com)
[![Support](https://img.shields.io/badge/support-contact%20author-blue])](https://fm2d.com/contact)

FM2D is a Web Agency publisher of Sylius plugins and open source actor. Since 2016, we strive to produce useful plugins to improve your e-commerce store. FM2D also offers you a first class technical support and customer service.

---

## Summary

---

* [Overview](#overview)
* [Installation](#installation)
* [License](#license)
* [Contact](#contact)

# Overview

---

* Sort products or taxons inside a taxon by simple drag and drop
	* Well-arranged overview of all taxons/products in the taxon
	* Disabled taxons/products greyed out
	* Direct links into taxon/product details
	* Optionally hidden taxon tree to get even more space

# Installation

## Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```shell
$ composer require fmdd/sylius-sorting-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

## Step 2: Enable the plugin

Then, enable the plugin by adding it to the end of the list of registered plugins/bundles
in `config/bundles.php` file of your project.

```php
<?php
# config/bundles.php
return [
    // ...
    Setono\SyliusTrustpilotPlugin\SetonoSyliusTrustpilotPlugin::class => ['all' => true],
    FMDD\SyliusSortingPlugin\FMDDSyliusSortingPlugin::class => ['all' => true],
    // ...
];
```
## Step 3: Add the plugin routing to your application

```yaml
# config/routes/sylius_admin.yaml
sylius_sorting_plugin:
    resource: "@FMDDSyliusSortingPlugin/Resources/config/routing.yml"
```

## Usage

* Log into admin panel
* Click on `Sorting products` in the Catalog section in main menu
* Select taxon
* Drag and drop cards
* Click `Save positions` button in the top right corner

# Development

## Usage

- Create symlink from .env.dist to .env or create your own .env file
- Develop your plugin in `/src`
- See `bin/` for useful commands

## Testing

After your changes you must ensure that the tests are still passing.

```bash
$ composer install
$ bin/console doctrine:schema:create -e test
$ bin/behat
$ bin/phpstan.sh
$ bin/ecs.sh
```

# Additional resources for developers

---
To learn more about our contribution workflow and more, we encourage you to use the following resources:
* [Sylius Documentation](https://docs.sylius.com/en/latest/)
* [Sylius Contribution Guide](https://docs.sylius.com/en/latest/contributing/)
* [Sylius Online Course](https://sylius.com/online-course/)

# License

---

This plugin's source code is completely free and released under the terms of the MIT license.

# Contact

---

If you have any questions, feel free to contact us by filling our form on [our website](https://fm2d.com/contact/) or send us an e-mail at [contact@fm2d.com](mailto:contact@fm2d.com) with your question(s). We will anwser you as soon as possible !
