=== Merchant AI Feed ===

Contributors: webclyde, zakir021063008
Tags: woocommerce, openai, feed, jsonl
Donate link: https://webclyde.com/donate
Requires at least: 5.8
Tested up to: 6.9
Requires PHP: 7.2
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Merchant AI Feed helps WooCommerce stores prepare their product catalogs for AI-powered discovery and conversational commerce.

== Description ==

Merchant AI Feed helps WooCommerce stores prepare their product catalogs for AI-powered discovery and conversational commerce. generates an AI-readable product feed optimized for modern AI assistants and AI-driven search systems, making it easier for your products to be discovered, understood, and referenced in AI-powered chat experiences such as ChatGPT, Claude, and other LLM-based assistants.

Merchant AI Feed focuses on product discovery readiness, structured product data, and performance-optimized synchronization, without handling payments or customer card data.

== Features: ==

- **AI Chat Discovery Ready**
 Products can be discovered and referenced in AI-powered chat experiences and AI search systems.

- **Agentic Commerce Protocol (ACP) Support**
 Full compliance with Agentic Commerce Protocol standards for AI assistant compatibility.

- **AI Assistant Compatibility**
 Designed to work with ChatGPT, Claude, and other LLM-powered assistants through AI-readable feeds.

- **Conversational Commerce Ready**
 Enable natural-language product discovery and shopping conversations.

- **Automatic Product Sync**
 Scheduled synchronization with AI discovery systems every 15 minutes.

- **Smart Product Discovery**
 AI-optimized product data formatting for improved search and recommendation accuracy.

- **Intelligent Catalog Management**
 Automatically structures product titles, pricing, availability, and metadata for AI consumption.

- **Secure API Integration**
 Enterprise-grade security with encrypted communication.

- **Performance Optimized**
 Efficient batch processing designed for large WooCommerce product catalogs.

- **Real-time Monitoring**
 Admin dashboard with synchronization statistics and AI access logs.

- **Multi-language Support**
 Available in English, Turkish, and Danish.

- **HPOS Compatible**
 Fully compatible with WooCommerce High-Performance Order Storage.

- **Developer Friendly**
 Clean, maintainable code following WordPress and WooCommerce coding standards.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/merchant-ai-feed` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Access the feed at `https://your-site.com/wp-json/merchant-ai/v1/feed`.

== Usage ==

The feed is available at the `https://your-site.com/wp-json/merchant-ai/v1/feed` endpoint.
It will prompt a file of `products.jsonl` which can be downloaded.

You can submit this URL or the downloaded file to OpenAI's Merchant interface.

== Frequently Asked Questions ==

= Does this plugin connect directly to ChatGPT? =
No. Merchant AI Feed prepares product data in an AI-readable format. It does not provide an official or direct integration with ChatGPT or OpenAI.

= Does Merchant AI Feed handle checkout or payments? =
No. The plugin does not process payments or manage checkout flows.

= How often is product data updated? =
Product data is synchronized automatically every 15 minutes.

= Is WooCommerce HPOS supported? =
Yes. Merchant AI Feed fully supports WooCommerce High-Performance Order Storage (HPOS).

= Can I choose which products are included? =
Yes. You can control which products are included in the AI-readable feed.

= Will this affect my site performance? =
No. The plugin is performance-optimized and uses batch processing.

== Screenshots ==

1. Product Feed Settings
2. WooCommerce Product Settings
3. HPOS Compatibility

== Changelog ==

= 1.0.0 =
* Initial release.

= 1.0.1 =
* Fix: plugin header urls out of service due to server SSL error.

= 1.1.0 =
* add: plugin action url to view feed url
* change: banner title case

= 1.2.1 =
* add: plugin dashboard page
* add: plugin required header
* change: dashboard original logo

== Upgrade Notice ==
