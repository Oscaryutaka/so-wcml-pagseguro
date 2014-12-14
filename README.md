# SO WCML PagSeguro

###### Last updated on 2014.12.14
###### requires at least WordPress 3.5
###### tested up to WordPress 4.1
###### Author: [Piet Bos](https://github.com/senlin)
###### Original plugin [WooCommerce PagSeguro](https://wordpress.org/plugins/woocommerce-pagseguro/)
###### Original authors: Claudio Sanches, Gabriel Reguly

Fork of WooCommerce PagSeguro plugin, made suitable for use in a multilingual environment (with WPML and WCML).

## Description

Adds PagSeguro gateway to a site that runs with WooCommerce, WPML and WooCommerceMultilingual. Quite obviously these 3 plugins therefore should be installed, otherwise it is completely useless to install SO WCML PagSeguro.

The difference between the original plugin and this fork is that with this fork we have removed the irritating and wrong error message that shows when you have the plugin installed on a site runnning WPML and WooCommerceMultilingual. This error message says that PagSeguro has been disabled (while it is in fact not). It doesn't only show on the PagSeguro settings page, but throughout the backend of the site and you can imagine that clients are not that enthusiastic to see that constantly...

The original plugin unfortunately also does not come with proper English instructions and we therefore have translated those too (Disclaimer: we used Google Translate).

[PagSeguro](https://pagseguro.uol.com.br/) is a **Brazilian payment method** developed by UOL.
**This means that if your store does not accept payment in BRL, you really do not need this plugin!!!**

The WooCommerce PagSeguro plugin was developed without any encouragement PagSeguro or UOL. None of the developers of that plugin have ties to any of these two companies.

This plugin was developed from the [official documentation](https://pagseguro.uol.com.br/v2/guia-de-integracao/visao-geral.html) (in Portuguese) of PagSeguro and uses the latest version of payments API.

The following methods of payment are available:

* Standard: The customer is redirected to PagSeguro to complete the purchase.
* Lightbox: A PagSeguro lightbox window opens to finalise the transaction.
* Transparent: The customer makes the payment directly on your site (using the PagSeguro API), without having to go to PagSeguro site.

It now is also possible to use the new [sandbox of PagSeguro](https://sandbox.pagseguro.uol.com.br/comprador-de-testes.html).

## Compatibility

Although the plugin is compatible with versions 2.0.x, 2.1.x, 2.2.x of WooCommerce, it is recommended to always use the latest versions of WPML and WooCommerceMultiLingual and therefore also WooCommerce.

This plugin is also compatible with the [WooCommerce Extra Checkout Fields for Brazil](http://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/), so you can send the "CPF" fields, "address number" and "neighborhood" (for the Transparent Checkout method it is mandatory to use this plugin).

## Installation

### Installing the plugin

* Upload the so-wcml-pagsegura folder to the wp-content/plugins folder, or install the zipfile using the installer of WordPress.
* Activate the plugin.

### Requirements
You must have a [PagSeguro](http://pagseguro.uol.com.br/)(Portuguese) account and have [WooCommerce](https://wordpress.org/plugins/woocommerce/), [WPML](http://senl.in/buyWPML) and [WooCommerceMultilingual](https://wordpress.org/plugins/woocommerce-multilingual/) installed.

### PagSeguro Settings

**Secure Setup**

In PagSeguro just accept receive payments only by **API**.
You must activate this option in "Integrações" > "[Pagamentos via API](https://pagseguro.uol.com.br/integracao/pagamentos-via-api.jhtml)" (Integration > Payments via API).
Only then it is possible to receive payments and to automatically return data.

### Plugin Settings

With the plugin installed you need to navigate to WooCommerce > Settings > Checkout > PagSeguro.

Enable PagSeguro, add your e-mail and the PagSeguro security token. The security token is used to generate the data to make payments and return.

You can get a PagSeguro security token on their website in Integrações > [Token de Segurança](https://pagseguro.uol.com.br/integracao/token-de-seguranca.jhtml) (Integration > Security Token).

You can choose from three payment options:

* Standard: The customer is redirected to PagSeguro to complete the purchase.
* Lightbox: A PagSeguro lightbox window opens to finalise the transaction.
* Transparent: The customer makes the payment directly on your site (using the PagSeguro API), without having to go to PagSeguro site.

Note: To use the transparent checkout you **must** use the [WooCommerce Extra Checkout Fields for Brazil](http://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/) plugin.
With WooCommerce Extra Checkout Fields for Brazil installed and enabled you must go to *WooCommerce > Checkout Fields* and set the *Display Type Person* as an *individual only*. This is necessary because it is mandatory to send CPF for PagSeguro, and the PagSeguro accepts only CPF. It is necessary to get approval of PagSeguro to use the Transparent Checkout; learn more in [Receiving payments by PagSeguro](https://pagseguro.uol.com.br/receba-pagamentos.jhtml) (Portuguese).

You can also define the behavior of integration using the options:

* Send only the order total: allows you to send only the order total in place of the list of items, this option should be used only when the order total in WooCommerce is different from the total in the PagSeguro.
* Request Prefix: This option is useful when you are using the same PagSeguro account at various shops and with that you can differentiate the shops by the prefix.


### WooCommerce Settings

In WooCommerce 2.0 or higher there is an option to cancel the purchase and release the stock after a few minutes.

This option does not work very well with the PagSeguro because payments by bank payment may take up to 48 hours to be validated.

To fix this you must go to *WooCommerce > Settings > Products > Inventory* and clear (leave blank) the option *Hold Stock (minutes)*.

**Done! Now your store can receive payments by PagSeguro.**

## Support

Please direct any support questions you might have to the [plugin's support forum]((http://wordpress.org/support/plugin/woocommerce-pagseguro). The only thing different in this fork is that we removed the irritating (and wrong) Error message that says that PagSeguro is disabled.
