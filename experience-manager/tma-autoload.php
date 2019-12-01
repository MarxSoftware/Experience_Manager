<?php

define("TMA_WEBTOOLS_CLASSES", array(
	"TMA\ExperienceManager\Integration" => "includes/modules/editors/class.integration.php",
	"TMA\ExperienceManager\Plugins" => "includes/class.plugins.php",
	"TMA\ExperienceManager\TMA_Request" => "includes/class.request.php",
	"TMA\ExperienceManager\TMA_COOKIE_HELPER" => "includes/class.cookie.php",
	"TMA_Settings_API" => "modules/class.settings-api.php",
	"TMA\ExperienceManager\TMAScriptHelper" => "includes/frontend/class.tma_script_helper.php",
	"TMA\ExperienceManager\Constants" => "includes/class.constants.php",
	"TMA\ExperienceManager\TMA_MetaBox" => "includes/backend/class.tma_metabox.php",
	"TMA\ExperienceManager\TMA_ShortCodes_Plugin" => "includes/backend/class.tma_shortcodes_plugin.php",
	"TMA\ExperienceManager\TMA_WPAdminBar" => "includes/backend/class.tma_wpadminbar.php",
	"TMA\ExperienceManager\TMA_Backend_Ajax" => "includes/backend/class.tma_ajax.",
	"TMA\ExperienceManager\TMA_Settings" => "includes/backend/class.tma_settings.",
	"TMA\ExperienceManager\ShortCode_TMA_CONTENT" => "includes/frontend/class.shortcode_tma_content.php",
	"TMA\ExperienceManager\TMA_Rest" => "includes/class.tma_rest.php",
	"TMA\ExperienceManager\Singleton" => "includes/class.singleton.php",
	
	// Widgets
	"TMA\ExperienceManager\TMA_Widget_Targeting" => "includes/widgets/class.widget_targeting.php",
	
	// Popup Maker
	"TMA\ExperienceManager\TMA_PopupMakerIntegration" => "includes/modules/messages/popup-maker/class.popup-maker.php",
	// Elementor
	"TMA\ExperienceManager\Elementor_Integration" => "includes/modules/editors/elementor/class.elementor_integration.php",
	"TMA\ExperienceManager\Elementor_Preview" => "includes/modules/editors/elementor/class.elementor_preview.php",
	// Advanced Ads
	"TMA\ExperienceManager\TMA_AdvancedAdsIntegration" => "includes/modules/ads/advanced/class.advanced_ads.php",
	// Gutenberg
	"TMA\ExperienceManager\Gutenberg_Integration" => "includes/modules/editors/gutenberg/class.gutenberg_integration.php",
	
	// Audience Editor
	"TMA\ExperienceManager\Segment\SegmentType" => "includes/backend/segment/class.segment-type.php",
	"TMA\ExperienceManager\Segment\SegmentEditor" => "includes/backend/segment/class.segment-editor.php",
	"TMA\ExperienceManager\Segment\SegmentEditorHelp" => "includes/backend/segment/class.segment-editor-help.php",
	// Event Tracking
	"TMA\ExperienceManager\Events\WC_TRACKER" => "includes/modules/events/class.woocommerce_tracker.php",
	"TMA\ExperienceManager\Events\EDD_TRACKER" => "includes/modules/events/class.edd_tracker.php",
	"TMA\ExperienceManager\Events\Base" => "includes/modules/events/class.ecommerce_base.php",	
));

function tma_webtools_autoload($class_name) {
	if (array_key_exists($class_name, TMA_WEBTOOLS_CLASSES)) {
		require_once TMA_EXPERIENCE_MANAGER_DIR . "/" . TMA_WEBTOOLS_CLASSES[$class_name];
	}
}

spl_autoload_register('tma_webtools_autoload');
