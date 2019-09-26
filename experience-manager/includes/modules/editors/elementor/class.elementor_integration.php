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

class Elementor_Integration extends Integration {

	/**
	 * Start up
	 */
	public function __construct() {

		parent::__construct();

		add_action('elementor/element/after_section_end', array($this, 'addControls'), 10, 3);
		add_action('elementor/frontend/widget/before_render', array($this, 'widget_before_render'), 10, 2);
	}

	static function getAttributes($element, $in_edit = false) {
		$settings = $element->get_settings();

		$attrs = [];
		$attrs["data-tma-personalization"] = Elementor_Integration::_isActivated($settings) ? "enabled" : "disabled";
		$attrs["data-tma-matching"] = $settings['tma_matching'];
		$attrs["data-tma-group"] = $settings['tma_group'];
		$attrs["data-tma-default"] = $settings['tma_default'];
		if (is_array($settings['tma_segments'])) {
			$attrs["data-tma-segments"] = implode(",", $settings['tma_segments']);
		} else {
			$attrs["data-tma-segments"] = $settings['tma_segment'];
		}
		if (!$in_edit) {
			if (tma_exm_is_frontend_mode_enabled() && Elementor_Integration::_isActivated($settings)) {
				if ($settings['tma_default'] === "no") {
					$attrs["class"] = 'tma-hide';
				}
			} else {
				if ($this->is_widget_visible($element) === FALSE) {
					$attrs["class"] = 'tma-hide';
				}
			}
		}


		return $attrs;
	}

	function widget_before_render(\Elementor\Element_Base $element) {
		tma_exm_log("widget_before_render");

		$attrs = Elementor_Integration::getAttributes($element);

		$element->add_render_attribute('_wrapper', $attrs);
	}

	function is_editor_active() {
		$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

		$action = NULL;
		if ($method === "POST") {
			$action = filter_input(INPUT_POST, 'action', FILTER_DEFAULT);
		} else {
			$action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
		}
		if ($action !== NULL) {
			return $action === "elementor" || TMAScriptHelper::startsWith($action, "elementor_");
		}
		return FALSE;
	}

	static function _isActivated($args) {
		return (is_array($args) && !empty($args['tma_personalization']) && $args['tma_personalization'] === "yes");
	}

	function isActivated($args) {
		return Elementor_Integration::_isActivated($args);
	}
	
	protected function isGroupDefault($args) {
		return (is_array($args) && !empty($args['tma_default']) && $args['tma_default'] === "yes");
	}

	function is_widget_visible($widget) {
		$visible = TRUE;
		$args = $widget->get_settings();
//		var_dump($args);
		if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			$visible = TRUE;
		} else {
			$visible = $this->is_visible($args);
		}
		return $visible;
	}

	function addControls($section, $section_id, $args) {
		if (\Elementor\Controls_Manager::TAB_ADVANCED !== $args['tab'] ||
				( '_section_responsive' !== $section_id /* Section/Widget */ && 'section_responsive' !== $section_id /* Column */
				)
		) {
			return;
		}

		$section->start_controls_section(
				'tma-webtools', [
			'label' => __('Targeting', 'tma-webtools'),
			'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
				]
		);

		$section->add_control(
				'tma_personalization', [
			'label' => __('Activate', 'tma-webtools'),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'description' => __('If enabled, the content will only be visible to users matching the selected segments.', 'tma-webtools'),
			'default' => 'np',
			'return_value' => 'yes',
			'label_off' => __('Deactive', 'tma-webtools'),
			'label_on' => __('Active', 'tma-webtools'),
				]
		);

		$section->add_control(
				'tma_matching', [
			'label' => __('Matching mode', 'tma-webtools'),
			'type' => \Elementor\Controls_Manager::SELECT,
			'description' => __('User must match all or just a single segment.', 'tma-webtools'),
			'default' => 'all',
			'options' => [
				'all' => __('All', 'tma-webtools'),
				'any' => __('Any', 'tma-webtools'),
				'none' => __('None', 'tma-webtools'),
			]
				]
		);

		$section->add_control(
				'tma_group', [
			'label' => __('Group', 'tma-webtools'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => "",
			'description' => __('The name of the group. Groups can be used to group elements together', 'tma-webtools'),
				]
		);

		$section->add_control(
				'tma_default', [
			'label' => __('Is Group default', 'tma-webtools'),
			'type' => \Elementor\Controls_Manager::SELECT,
			'description' => __('Is group default element. The default is used if not other element of the groups matchs the user. The default element must be the last element on the page.', 'tma-webtools'),
			'default' => 'yes',
			'options' => [
				'yes' => __('Yes', 'tma-webtools'),
				'no' => __('No', 'tma-webtools'),
			]
				]
		);

		$segment_options = tma_exm_get_segments_as_array_flat();

		$section->add_control(
				'tma_segments', [
			'label' => __('Audiences', 'tma-webtools'),
			'type' => \Elementor\Controls_Manager::SELECT2,
			"description" => __("For which segments the content should be visible.", "tma-webtools"),
			'default' => [],
			'options' => $segment_options,
			'multiple' => true,
				]
		);

		$section->end_controls_section();
	}

}

//$tma_elementor_integration = new Elementor_Integration();
