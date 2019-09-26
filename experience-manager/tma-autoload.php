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
	// Beaver Builder
	"TMA\ExperienceManager\BeaverBuilder_Integration" => "includes/modules/editors/beaver/class.beaverbuilder_integration.php",
	"TMA\ExperienceManager\TMA_BeaverBuilderPreview" => "includes/modules/editors/beaver/class.beaverbuilder.preview.php",
	
	// Audience Editor
	"TMA\ExperienceManager\Segment\SegmentType" => "includes/backend/segment/class.segment-type.php",
	"TMA\ExperienceManager\Segment\SegmentEditor" => "includes/backend/segment/class.segment-editor.php",
	"TMA\ExperienceManager\Segment\Translator" => "includes/backend/segment/class.translator.php",
	// UniRest
	/*
	"Unirest\Request" => "modules/unirest/Unirest/Request.php",
	"Unirest\Response" => "modules/unirest/Unirest/Response.php",
	"Unirest\Method" => "modules/unirest/Unirest/Method.php",
	"Unirest\Exception" => "modules/unirest/Unirest/Exception.php",
	"Unirest\Request\Body" => "modules/unirest/Unirest/Request/Body.php",
	*/
	// Event Tracking
	"TMA\ExperienceManager\WC_TRACKER" => "includes/modules/events/class.woocommerce_tracker.php",
));

function tma_webtools_autoload($class_name) {
	if (array_key_exists($class_name, TMA_WEBTOOLS_CLASSES)) {
		require_once TMA_EXPERIENCE_MANAGER_DIR . "/" . TMA_WEBTOOLS_CLASSES[$class_name];
	}
}

spl_autoload_register('tma_webtools_autoload');
