# JBrada - Well-Known Change Password Magento 2 Module

[![Magento Package Maven Badge](https://package-maven.com/badge/jbrada/module-admin-document-product-links?style=plastic)](https://package-maven.com/jbrada/module-admin-document-product-links)
![Code Analysis](https://github.com/jbrada/module-well-known-change-password/actions/workflows/code-analysis.yml/badge.svg)
![Tests](https://github.com/jbrada/module-well-known-change-password/actions/workflows/tests.yml/badge.svg)

## Overview

The `JBrada_WellKnownChangePassword` module implements the [`.well-known/change-password`](https://wicg.github.io/change-password-url/) standard for Magento 2. This allows password managers to easily locate and redirect users to the correct URL when they wish to change their password.

While there are multiple ways to achieve this functionality, such as adding custom URL rewrites in Magento or configuring the webserver, this method directly integrates it within Magento itself. By doing so, the URL is permanently tied into Magento, eliminating the need for further configuration or maintenance.

The module creates a well-known URL `/.well-known/change-password` that redirects to the Magento customer edit page, where users can manage their account and update their password.

## Installation

To install the module via composer, run the following command:

```bash
composer require jbrada/module-well-known-change-password
```

Enable the module in Magento:

```bash
bin/magento module:enable JBrada_WellKnownChangePassword
bin/magento setup:upgrade
```

## Usage

Once installed, the module automatically exposes the `/.well-known/change-password` URL on your Magento site. When visited, this URL will redirect to the customer password change page where users can manage their password.

### Example

If your Magento store URL is `https://example.com`, visiting:

```
https://example.com/.well-known/change-password
```

will redirect to:

```
https://example.com/customer/account/edit/changepass/1/
```

## Tools Implementing This Standard

This standard is already supported by a number of tools, including:

- iCloud Keychain (iOS 12)
- Safari 12
- 1Password (1Password 8, and 1Password for Chrome, Firefox, Edge, and macOS Safari)
- Chrome 86
- Backdrop CMS (via the Well-known module)

## License

This module is licensed under MIT license. Please refer to the `LICENSE.md` file for more information.

## Note on Testing

This repository utilizes [ExtDN's GitHub Actions for Magento 2](https://github.com/extdn/github-actions-m2) to run tests in GitHub Actions.

## About

This project is created by [Jiří Brada](https://jbrada.cz) and is a non-profit initiative to support the Magento community. 

Have feedback? I'd love to [hear from you](mailto:jiri@jbrada.cz).

Connect with me on [LinkedIn](https://www.linkedin.com/in/jbrada) or visit my [website](https://jbrada.cz).
