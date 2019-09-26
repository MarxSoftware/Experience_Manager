<?php

/*
 * Copyright (C) 2017 marx
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace TMA\ExperienceManager;

class Elementor_Preview {

	/**
	 * Start up
	 */
	public function __construct() {
		add_action('elementor/element/post/document_settings/after_section_end', array($this, 'add_elementor_page_settings_controls'));

		add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

		add_action("elementor/widget/render_content", function ($content, $element) {
			if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
				$attrs = Elementor_Integration::getAttributes($element, true);
				$element->add_render_attribute('exm_wrapper', $attrs);
				return '<div id="exm_wrapper" ' . $element->get_render_attribute_string('exm_wrapper') . ' >' . $content . "</div>";
			}
			return $content;
		}, 10, 3);
	}

	function widget_scripts() {
		wp_register_script('exm-elementor', plugins_url('experience-manager/assets/elementor/experience-manager-elementor.js'), [], "2.1.0", true);
		wp_enqueue_script('exm-elementor');
	}

	function add_elementor_page_settings_controls(\Elementor\Core\DocumentTypes\Post $page) {

		$page->start_controls_section(
				'tma_exm_preview', [
			'label' => __('Targeting Preview', 'tma-webtools'),
			'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
				]
		);

		$page->add_control(
				'exm_toggle_preview',
				[
					'label' => __('Toggle preview', 'tma-webtools'),
					'type' => \Elementor\Controls_Manager::BUTTON,
					'separator' => 'before',
					'button_type' => 'success',
					'text' => __('Preview', 'tma-webtools'),
					'event' => 'exm:editor:preview',
				]
		);

		$page->end_controls_section();
	}

}

/**
 function handleMenuItemColor ( newValue ) {
	console.log( newValue );
	elementor.reloadPreview();
}
 elementor.settings.page.addChangeCallback( 'menu_item_color', handleMenuItemColor );
  
 */

//$tma_elementor_integration = new Elementor_Integration();
