=== Experience Manager ===
Contributors: thmarx
Tags: digital experience platform, experience manager, targeting, analytics, tracking, product targeting, behaviour targets
Requires at least: 4.4.1
Tested up to: 5.3.2
Stable tag: 2.4.2
License: GPLv2 or later

Do not treat all your customers the same, create a digital experience!

== Description ==

This plugin is an integration for the Experience Platform an opensource event analytics and segmentation platform.

Features:

* Tracking of user events
* Scoring for user behaviour
* User segmentation
* Content targeting via shortcodes fro classic editor
* Segment simulator in the preview
* Support for [Elementor Page Builder](https://elementor.com/)
* Support For [Gutenberg](https://wordpress.org/gutenberg/)
* Template-Tag to check if a user match a specific segment ( e.q. tma_exm_is_in_segment("a_segment_id"))
* Support for Cache Plugins
* Support for [Popup Maker](https://wppopupmaker.com/)
* Support for [Advanced Ads](https://wpadvancedads.com/)


[youtube https://www.youtube.com/watch?v=ovwScstmPVA]

== Installation ==

This section describes how to install the plugin and get it working.
You need to install webTools from https://wp-digitalexperience.com/experience-platform/

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the "Experience Manager->Settings" menu to configure the plugin

== Usage ==
The Experience Manager let you define user segments directly in the WordPress backend. It integrates inot different page builders where you can use user segments
to create targeted content for these segments.




== Frequently Asked Questions ==

= Can I use the plugin without Experience Platform? =
No, the plugin integrates Experience Platform into WordPress. It is not possible to use it without the Experience Platform.

= Is Experience Platform free? =
Yes, it is. As this plugin, Experience Platform is licensed under the GPLv3 or later

= Is this addon compatible with other WordPress cache addons like WP Super Cache? =
Yes, since version 2 the Experience Manager supports frontend and backend targeting.


== Known issues ==

none

== Changelog ==

2.5.0
 * Generate unique id for cart tracking

2.4.2
 * Typo fixed

2.4.1
 * Typo fixed
 * Don't load drafts for audience selection in editors or preview

2.4.0
 * Intro to the segment editor added
 * Simple wizard to getting started with the segment editor
 * tracking of easy digital downloads ecommerce events: add_to_cart, remove_from_cart and order

IMPORTANT: If you upgrade to version 2.4.0 you need at least Experience Platform version 3.6.0

2.3.0
 * cookie handling fixed

2.2.0
 * Add highlighting of widgets with configured targeting to elementor
 * Segment editor publish-save-order issue fixed
 * Javascript for updating segments fixed
 * Widget Targeting removed due to bug 

2.1.0
 * Update to new the new tracking url provided by the Experience Platform
 * Beaver Builder support removed

IMPORTANT: If you upgrade to version 2.1.0 you need at least Experience Platform version 3.3.1

2.0.0
 * The plugin is renamed into Experience Manager
 * Update JS library webtools
 * Rest endpoint added to get user segments
 * Add support for cache plugins
 * Tracking of wordpress and woocommerce categories 
 * Removed support for SiteOrigin PageBuilder and WPBakery PageBuilder
 * Support for Popup Maker added
 * Support for Advanced Ads added
 * Extended Toolbar integration with preview and highlight added

IMPORTANT: If you upgrade to version 2.0.0 you need at least webTools-Platform version 2.2.0

1.5.1
 * fix Beaver Builder integration
 * fix WPBakery PageBuilder integration

1.5.0
 * Beaver Builder support added
 * Redux Framework removed
 * Extended support vor WPBakery PageBuilder

= 1.4.1 =
 * Fix Elementor preview issue

= 1.4.0 =
 * Add support for Elementor PageBuilder

= 1.3.2 =
 * add missing files

= 1.3.1 =
 * remove debug logging

= 1.3.0 =
 * Update ReduxFramework to 3.6.5
 * Modify MetaData of posts containing segmented content
 * Add targeting to widgets

= 1.2.0 =
 * Add support for cookie domain
 * Add hook for recommendations

= 1.1.1 =
 * MetaBox Bugfix

= 1.1.0 =
 * Use the ReduxFramework for settings
 * Replace WooCommerce recommendation

= 1.0.1 =
 * Tracking should be disabled in the preview
 * Disable tracking in SiteOrigin PageBuilder live editor
 * Disable tracking in VisualComposer frontend editor

= 1.0.0 =
 * Fix js issue with tinymce integration
 * Support for PageBuilder by SiteOrigin
 * Support for Visual Composer
 * New template tag

IMPORTANT: If you upgrade to version 1.0.0 you need at least webTools-Platform version 1.1.0

= 0.10.0 = 
 * Fix error in adminbar
 * MetaBox for scoring
 * Tracking of add/remove item to/from cart
 * Use of post type and slug for unique tracking

= 0.9.0 =
 * Add segment selector to the preview
 * webTools version 0.12.0 is the minimum version

= 0.8.0 = 
 * Hook to integration custom configuration into the TMA_CONFIG Json
 * TMA_Request class extended to call extension rest endpoints
 * fix issue with webtools rest api

= 0.7.0 =
* usage of new tracking of custom attributes
* enable/disable tracking for logged in users
* tracking of product ids for orders
* tinymce button for shortcodes

If you update to this version you need at least version 0.9.0 of the webTools-Platform.


= 0.6.0 =
* add scoring only if single page of post is shown

= 0.5.0 =
* Fix cookie issue

= 0.4.0 =
* Tracking of WooCommerce events

= 0.3.0 =
* Fix minor issue with unhandled NULL value
* add translation

= 0.2.0 =
* ShortCodes for content targeting by user segments

= 0.1.0 =
* Disable/Enable tracking and scoring.

== Upgrade Notice ==
 * since version 0.10.0 the post type is used to generate a unique page id, if you use pageview for segmentation in the webTools-Platform, you have to update your rules to <post_type>#<post_slug>.
 * version 0.10.0 you need at least webTools version 0.14.0
 * For version 0.8.0 you need at least webTools version 0.11.0
