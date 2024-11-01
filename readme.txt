=== Plugin Name ===
Contributors: clifgriffin
Tags: shopp, shipping, filters
Requires at least: 3.4
Tested up to: 4.8.0
Stable tag: 2.0.1

Allows users of Shopp 1.3.x to filter the shipping options available to customers by the category cart items belong to.

== Description ==

For some stores, the default configuration of shipping options may not be enough.  Say you have frozen items, and you only want to show one set of rates if those items are in the cart and hide them the rest of the time? Shopp doesn't natively support this configuration.  With Shopp Category Shipping Filters, you can configure each product category that applies to each shipping method.

**Donate?**

If you use this plugin and find that it serves your needs well, please consider a donation.

**Support**

If you need support, contact us: https://objectiv.co/contact.

= Version History =
**Version 2.0.1**

* Fix issue with name spacing case sensitivity. 

**Version 2.0**

* Breaks backwards compatibility.
* Removes support for Shopp 1.2.
* Adds support for 1.3.
* Adds show and hide categories.
* Completely rewritten from the ground up.

**Version 1.0:**

* Initial release.

== Installation ==

1. Upload the directory "shopp-category-shipping-filters" to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Shopp -> Shipping Filters.

== Frequently Asked Questions ==

= Can I filter by the specific shipping options of one provider (ie, FedEx)? =

No. This only applies to the provider, not the specific rate options returned by a provider.
