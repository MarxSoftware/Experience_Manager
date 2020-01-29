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

namespace TMA\ExperienceManager\Modules\Editors\Divi;

class DiviBuilder_Integration extends \TMA\ExperienceManager\Integration {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Start up
	 */
	public function __construct() {
		parent::__construct();
	}

	public function init() {
		$divi_elements = ["et_pb_section", "et_pb_row"];

		$divi_elements = apply_filters("experience-manager/editor/divi/elements", $divi_elements);

		foreach ($divi_elements as $element) {
			$this->exm_divi_config_fields($element);
		}
	}

	function exm_divi_config_fields($tag) {

		add_filter("et_pb_all_fields_unprocessed_${tag}", function ($fields_uncompressed) {
			$fields = [];
			$fields['exm_targeting'] = [
				'label' => 'Targeting',
				'description' => 'Enable targeting',
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => [
					'off' => "Off",
					'on' => "On"
				],
				"default" => "off",
				"tab_slug" => "custom_css",
				"toggle_slug" => "visibility"
			];
			$fields['exm_targeting_matching'] = [
				'label' => 'Matching mode',
				'description' => 'matching mode',
				'type' => 'select',
				'option_category' => 'basic_option',
				'default' => 'all',
				'options' => array(
					'all' => "All",
					'any' => 'Any',
					'none' => 'None'
				),
				"tab_slug" => "custom_css",
				"toggle_slug" => "visibility",
				"show_if" => [
					"exm_targeting" => "on"
				]
			];
			$fields['exm_targeting_group'] = [
				'label' => 'Group',
				'description' => 'Targeting group',
				'type' => 'text',
				'option_category' => 'basic_option',
				"default" => "default",
				"tab_slug" => "custom_css",
				"toggle_slug" => "visibility",
				"show_if" => [
					"exm_targeting" => "on"
				]
			];

			$fields['exm_targeting_audiences'] = [
				'label' => 'Audiences',
				'description' => 'Das ist meine Test einstellung',
				'type' => 'multiple_checkboxes',
				'option_category' => 'basic_option',
				'options' => array(
					'option_1' => 'First Visitor',
					'option_2' => 'Returning Visitor',
					'option_3' => 'Regular customer',
				),
				"tab_slug" => "custom_css",
				"toggle_slug" => "visibility",
				"show_if" => [
					"exm_targeting" => "on"
				]
			];



			return array_merge($fields_uncompressed, $fields);
		});

		add_filter("${tag}_data_attributes", function ($attributes, $properties, $count) {
			if (array_key_exists('exm_targeting', $properties) && 'on' === $properties['exm_targeting']) {
				$attributes["tma-personalication"] = "enabled";
				$attributes["meinAttribute"] = "enabled";
			}
			return $attributes;
		}, 10, 3);
	}

}
