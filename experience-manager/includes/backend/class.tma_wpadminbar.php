<?php

/*
 * Copyright (C) 2016 marx
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

/**
 * Description of class
 *
 * @author marx
 */
class TMA_WPAdminBar {

	public function __construct() {
		if (!is_admin()){
			add_action('wp_enqueue_scripts', array($this, 'init_javascript'));

			add_action('admin_bar_menu', array($this, 'tma_segment_links'), 900);
			
			//add_action( 'wp_footer', array( $this, 'admin_bar_styles' ), 999 );	
			add_action( 'wp_enqueue_scripts', array( $this, 'admin_bar_styles' ), 999 );	
		}
	}
	
	public static function admin_bar_styles() {

		if ( is_admin() || ! is_admin_bar_showing()  ) {
			return;
		}
		
		wp_register_style( 'tma-webtools-adminbar-style', plugins_url( 'experience-manager/css/tma-adminbar.css' ), [], false );
		wp_enqueue_style( 'tma-webtools-adminbar-style' );
		
	}

	function tma_segment_links($wp_admin_bar) {


		$wp_admin_bar->add_node(array(
			'id' => 'webtools-adminbar',
			'title' => __("Experience Manager", "tma-webtools"),
			'meta'   => array( 'class' => 'webtools-adminbar' ),
		));
		
		$wp_admin_bar->add_node(array(
			'parent' => "webtools-adminbar",
			'id' => 'variants-show',
			'title' => __("Show variants", "tma-webtools"),
			'href' => '#',
			'meta' => array(
				'onclick' => "tma_show_variants(this); return false;"
			)
		));
		$wp_admin_bar->add_node(array(
			'parent' => "webtools-adminbar",
			'id' => 'variants-highlight',
			'title' => __("Highlight variants", "tma-webtools"),
			'href' => '#',
			'meta' => array(
				'onclick' => "tma_highlight(this); return false;"
			)
		));

		$args = array(
			'parent' => "webtools-adminbar",
			'id' => 'segment_selector',
			'title' => __("Target Audience", "tma-webtools"),
			'meta' => array('class' => 'first-toolbar-group'),
		);
		$wp_admin_bar->add_node($args);

		$args = array();

		$segments = tma_exm_get_segments_as_array();
		tma_exm_log("hier sind die segmente");
		tma_exm_log(json_encode($segments));
		if (sizeof($segments) > 0) {
			foreach ($segments as $segment) {
				array_push($args, array(
					'id' => $segment->id,
					'title' => $segment->name,
					'href' => '#',
					'parent' => 'segment_selector',
					'meta' => array(
						'onclick' => 'tma_segment_selector(this); return false;',
						'class' => $segment->id
					)
				));
			}
		} else {
			array_push($args, array(
				'id' => 'emtpy',
				'title' => __("No segments found", "tma-webtools"),
				'parent' => 'segment_selector',
			));
		}

		sort($args);

		array_push($args, array(
			'id' => 'clear',
			'title' => 'Clear Segments',
			'href' => '#',
			'parent' => 'segment_selector',
			'meta' => array(
				'onclick' => "tma_segment_clear(); return false;"
			)
		));


		for ($a = 0; $a < sizeOf($args); $a++) {
			$wp_admin_bar->add_node($args[$a]);
		}
	}

	public function init_javascript() {
		wp_enqueue_script('experience-manager', TMA_EXPERIENCE_MANAGER_URL . 'js/experience-manager.js', array("experience-manager-exm"), "1");
	}

}

if (is_admin_bar_showing() && tma_exm_admin_bar_visible()) {
	$tma_adminbar = new TMA_WPAdminBar();
}

