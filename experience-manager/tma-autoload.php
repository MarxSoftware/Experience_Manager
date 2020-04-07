<?php

define("TMA_WEBTOOLS_CLASSES", array(
	"TMA\ExperienceManager\Integration" => "includes/modules/editors/class.integration.php",
	"TMA\ExperienceManager\Plugins" => "includes/class.plugins.php",
	"TMA\ExperienceManager\TMA_Request" => "includes/class.request.php",
	"TMA\ExperienceManager\TMA_COOKIE_HELPER" => "includes/class.cookie.php",
	"TMA_Settings_API" => "dependencies/class.settings-api.php",
	"TMA\ExperienceManager\TMAScriptHelper" => "includes/frontend/class.tma_script_helper.php",
	"TMA\ExperienceManager\Constants" => "includes/class.constants.php",
	"TMA\ExperienceManager\TMA_MetaBox" => "includes/backend/class.tma_metabox.php",
	"TMA\ExperienceManager\TMA_ShortCodes_Plugin" => "includes/backend/class.tma_shortcodes_plugin.php",
	"TMA\ExperienceManager\TMA_WPAdminBar" => "includes/backend/class.tma_wpadminbar.php",
	"TMA\ExperienceManager\TMA_Backend_Ajax" => "includes/backend/class.tma_ajax.php",
	"TMA\ExperienceManager\TMA_Settings" => "includes/backend/class.tma_settings.php",
	"TMA\ExperienceManager\ShortCode_TMA_CONTENT" => "includes/frontend/class.shortcode_tma_content.php",
	"TMA\ExperienceManager\TMA_Rest" => "includes/class.tma_rest.php",
	"TMA\ExperienceManager\Singleton" => "includes/class.singleton.php",
	
	// Widgets
	"TMA\ExperienceManager\TMA_Widget_Targeting" => "includes/widgets/class.widget_targeting.php",
	
	// Integrations
	"TMA\ExperienceManager\Modules\Integrations" => "includes/modules/class.integrations.php",
	// Popup Maker
	"TMA\ExperienceManager\TMA_PopupMakerIntegration" => "includes/modules/messages/popup-maker/class.popup-maker.php",
	// WP Popups
	"TMA\ExperienceManager\WP_Popups" => "includes/modules/messages/wp-popups/class.wp-popups.php",
	// Elementor
	"TMA\ExperienceManager\Elementor_Integration" => "includes/modules/editors/elementor/class.elementor_integration.php",
	"TMA\ExperienceManager\Elementor_Preview" => "includes/modules/editors/elementor/class.elementor_preview.php",
	"TMA\ExperienceManager\ElementorPopupIntegration" => "includes/modules/messages/elementor/class.elementor-popup.php",
	"TMA\ExperienceManager\Base" => "includes/modules/messages/elementor/class.base.php",
	// Advanced Ads
	"TMA\ExperienceManager\TMA_AdvancedAdsIntegration" => "includes/modules/ads/advanced/class.advanced_ads.php",
	// Gutenberg
	"TMA\ExperienceManager\Gutenberg_Integration" => "includes/modules/editors/gutenberg/class.gutenberg_integration.php",
	// DIVI
	"TMA\ExperienceManager\Modules\Editors\Divi\DiviBuilder_Integration" => "includes/modules/editors/divi/class.divibuilder_integration.php",
	// Beaver Builder
	"TMA\ExperienceManager\Beaver\BeaverBuilder_Integration" => "includes/modules/editors/beaver/class.beaverbuilder_integration.php",
	"TMA\ExperienceManager\Beaver\BeaverBuilder_Preview" => "includes/modules/editors/beaver/class.beaverbuilder.preview.php",
	
	// Audience Editor
	"TMA\ExperienceManager\Segment\SegmentType" => "includes/backend/segment/class.segment-type.php",
	"TMA\ExperienceManager\Segment\SegmentEditor" => "includes/backend/segment/class.segment-editor.php",
	"TMA\ExperienceManager\Segment\SegmentEditorHelp" => "includes/backend/segment/class.segment-editor-help.php",
	"TMA\ExperienceManager\Segment\SegmentEditorMetaBoxes" => "includes/backend/segment/class.segment-editor-metabox.php",
	"TMA\ExperienceManager\Segment\SegmentRequest" => "includes/backend/segment/class.segment-request.php",
	"TMA\ExperienceManager\Segment\SegmentValidator" => "includes/backend/segment/class.segment-validator.php",
	// Event Tracking
	"TMA\ExperienceManager\Events\WC_TRACKER" => "includes/modules/events/class.woocommerce_tracker.php",
	"TMA\ExperienceManager\Events\EDD_TRACKER" => "includes/modules/events/class.edd_tracker.php",
	"TMA\ExperienceManager\Events\Base" => "includes/modules/events/class.ecommerce_base.php",	
	// Content Editor
	"TMA\ExperienceManager\Content\Flex_Content" => "includes/backend/content/class.content.php",
	"TMA\ExperienceManager\Content\Flex_Content_Engine" => "includes/backend/content/class.content-engine.php",
	"TMA\ExperienceManager\Content\ContentType" => "includes/backend/content/class.content-type.php",
	"TMA\ExperienceManager\Content\ContentEditor" => "includes/backend/content/class.content-editor.php",
	"TMA\ExperienceManager\Content\ContentEditorMetaBox" => "includes/backend/content/class.content-editor-metabox.php",
	"TMA\ExperienceManager\Content\ContentSettingsMetaBox" => "includes/backend/content/class.content-settings-metabox.php",
	"TMA\ExperienceManager\Content\ContentShortCode" => "includes/backend/content/class.content-shortcode.php",
	"TMA\ExperienceManager\Content\ContentAjax" => "includes/backend/content/class.content-ajax.php",
	// Ecommerce Helper classes
	"TMA\ExperienceManager\Modules\ECommerce\Ecommerce" => "includes/modules/ecommerce/class.ecommerce.php",
	"TMA\ExperienceManager\Modules\ECommerce\Ecommerce_EDD" => "includes/modules/ecommerce/class.ecommerce-edd.php",
	"TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo" => "includes/modules/ecommerce/class.ecommerce-woo.php",
));

function tma_webtools_autoload($class_name) {
	if (array_key_exists($class_name, TMA_WEBTOOLS_CLASSES)) {
		require_once TMA_EXPERIENCE_MANAGER_DIR . "/" . TMA_WEBTOOLS_CLASSES[$class_name];
	}
}

spl_autoload_register('tma_webtools_autoload');
