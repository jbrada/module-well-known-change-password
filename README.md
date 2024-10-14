# JBrada - Well-Known Change Password Magento 2 Module

## Overview

The `JBrada_WellKnownChangePassword` module implements the [`.well-known/change-password`](https://wicg.github.io/change-password-url/) standard for Magento 2. This allows password managers to easily locate and redirect users to the correct URL when they wish to change their password. 

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

Once installed, the module automatically exposes the `/.well-known/change-password` URL on your Magento site. When visited, this URL will redirect to the customer login page where users can manage their password.

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
