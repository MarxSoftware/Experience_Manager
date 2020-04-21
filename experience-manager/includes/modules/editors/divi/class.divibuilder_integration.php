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
		$this->register_taxonomy();
		$this->register_get_terms();

		$divi_elements = ["et_pb_section"];

		$divi_elements = apply_filters("experience-manager/editor/divi/elements", $divi_elements);

		foreach ($divi_elements as $element) {
			$this->exm_divi_config_fields($element);
		}
		
		add_filter( 'wp_enqueue_scripts', [$this, "init_frontent_scripts"], 0 );
	}
	
	function init_frontent_scripts () {
//		wp_enqueue_script('experience-manager-divi', TMA_EXPERIENCE_MANAGER_URL . 'assets/divi/experience-manager-divi.js', array("experience-manager-hooks"), "1");
	}

	function register_get_terms() {
		add_filter('get_terms', function($terms, $taxonomies, $args, $term_query) {
			if (in_array("exm_segments", $taxonomies)) {
				$segment_options = tma_exm_get_segments_as_array_flat();
				$exm_terms = [];
				foreach ($segment_options as $key => $value) {
					$exm_terms[] = (object) ['term_id' => $key, "name" => $value];
				}
				return $exm_terms;
			} else {
				return $terms;
			}
		}, 1, 4);
	}

	function exm_divi_config_fields($tag) {

		add_filter("et_pb_all_fields_unprocessed_${tag}", function ($fields_uncompressed) {
			$segment_options = tma_exm_get_segments_as_array_flat();
			$fields = [];
			$fields['exm_targeting'] = [
				'label' => 'Targeting',
				'description' => __('If enabled, the content will only be visible to users matching the selected segments.', 'tma-webtools'),
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
				'description' => __('User must match all or just a single segment.', 'tma-webtools'),
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
				'description' => __('The name of the group. Groups can be used to group elements together', 'tma-webtools'),
				'type' => 'text',
				'option_category' => 'basic_option',
				"default" => "default",
				"tab_slug" => "custom_css",
				"toggle_slug" => "visibility",
				"show_if" => [
					"exm_targeting" => "on"
				]
			];
			$fields['exm_targeting_group_default'] = [
				'label' => 'Group default',
				'description' => __('Is group default element. The default is used if not other element of the groups matchs the user. The default element must be the last element on the page.', 'tma-webtools'),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => [
					'off' => "Off",
					'on' => "On"
				],
				"default" => "off",
				"tab_slug" => "custom_css",
				"toggle_slug" => "visibility",
				"show_if" => [
					"exm_targeting" => "on"
				]
			];

			$fields['exm_targeting_audiences'] = [
				'label' => 'Audiences',
				"description" => __("For which audiences the content should be visible.", "tma-webtools"),
				'type' => 'categories',
				'option_category' => 'basic_option',
				'taxonomy_name' => 'exm_segments',
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
//				var_dump($properties);
				$attributes["tma-personalization"] = "enabled";
				$attributes["tma-matching"] = $properties['exm_targeting_matching'];
				$attributes["tma-group"] = $properties['exm_targeting_group'];
				$attributes["tma-default"] = $properties['exm_targeting_group_default'] === "on" ? "yes" : "no";
				$attributes["tma-divi-default"] = $properties['exm_targeting_group_default'] === "on" ? "yes" : "no";
				if (is_array($properties['exm_targeting_audiences'])) {
					$attributes["tma-segments"] = implode(",", $properties['exm_targeting_audiences']);
				} else {
					$attributes["tma-segments"] = $properties['exm_targeting_audiences'];
				}
			}
			return $attributes;
		}, 10, 3);
	}

	// Register Custom Taxonomy
	public function register_taxonomy() {

		$labels = array(
			'name' => _x('Audiences', 'Taxonomy General Name', 'tma-webtools'),
			'singular_name' => _x('Audience', 'Taxonomy Singular Name', 'tma-webtools'),
			'menu_name' => __('Audience', 'tma-webtools'),
			'all_items' => __('All Items', 'tma-webtools'),
			'parent_item' => __('Parent Item', 'tma-webtools'),
			'parent_item_colon' => __('Parent Item:', 'tma-webtools'),
			'new_item_name' => __('New Item Name', 'tma-webtools'),
			'add_new_item' => __('Add New Item', 'tma-webtools'),
			'edit_item' => __('Edit Item', 'tma-webtools'),
			'update_item' => __('Update Item', 'tma-webtools'),
			'view_item' => __('View Item', 'tma-webtools'),
			'separate_items_with_commas' => __('Separate items with commas', 'tma-webtools'),
			'add_or_remove_items' => __('Add or remove items', 'tma-webtools'),
			'choose_from_most_used' => __('Choose from the most used', 'tma-webtools'),
			'popular_items' => __('Popular Items', 'tma-webtools'),
			'search_items' => __('Search Items', 'tma-webtools'),
			'not_found' => __('Not Found', 'tma-webtools'),
			'no_terms' => __('No items', 'tma-webtools'),
			'items_list' => __('Items list', 'tma-webtools'),
			'items_list_navigation' => __('Items list navigation', 'tma-webtools'),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'public' => false,
			'show_ui' => false,
			'show_admin_column' => false,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'rewrite' => false,
			'show_in_rest' => false,
		);
		register_taxonomy('exm_segments', array(''), $args);
	}

}
