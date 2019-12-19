<?php

namespace TMA\ExperienceManager;

/**
 * PopUpMaker Inteegration
 *
 * @since 2.0
 */
final class ElementorPopupIntegration extends Base {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 2.0
	 * @return void
	 */
	public function init() {
		add_action('elementor/element/before_section_end', array($this, "integrate"), 10, 3);
		
		add_action('wp_footer', function () {
			$image_url = plugins_url( 'experience-manager/images/audience.png' );
			?>
			jQuery.ready(function () {
				if ( window.elementorFrontend ) {
					elementorFrontend.hooks.addFilter( 'init', function( ) {
						jQuery("#elementor-popup__timing-controls-group--exm_segments .elementor-popup__display-settings_controls_group__icon img").attr("src" , "<?php echo $image_url; ?>");
					} );
				}
			});
			<?php
		}, 100);
	}

	function integrate($section, $section_id, $args) {
		if ($section_id === "timing") {
			$this->start_settings_group($section, 'exm_segments', __('Audiences', 'tma-webtools'));

			$segment_options = tma_exm_get_segments_as_array_flat();
			
			$this->add_settings_group_control(
					$section,
					'exm_segments',
					[
						'type' => \Elementor\Controls_Manager::SELECT2,
						'multiple' => true,
						'default' => $segment_options,
						'options' => $segment_options,
					]
			);

			//$section->end_settings_group();
			$this->end_settings_group($section);
		}
	}

}
