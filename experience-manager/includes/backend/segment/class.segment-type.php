<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Segment;

/**
 * Description of class
 *
 * @author marx
 */
class SegmentType {

	public static $TYPE = "tma_segment";

	/**
	 * instance
	 *
	 * Statische Variable, um die aktuelle (einzige!) Instanz dieser Klasse zu halten
	 *
	 * @var Singleton
	 */
	protected static $_instance = null;

	/**
	 * get instance
	 *
	 * Falls die einzige Instanz noch nicht existiert, erstelle sie
	 * Gebe die einzige Instanz dann zurück
	 *
	 * @return   Singleton
	 */
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * clone
	 *
	 * Kopieren der Instanz von aussen ebenfalls verbieten
	 */
	protected function __clone() {
		
	}

	/**
	 * constructor
	 *
	 * externe Instanzierung verbieten
	 */
	protected function __construct() {
		
	}

	/**
	 * check if the current page is the segment editor
	 * 
	 * @return boolean
	 */
	static function isAudienceEditor() {
		$screen = get_current_screen();
		if (is_object($screen) && SegmentType::$TYPE === $screen->post_type) {
			return TRUE;
		}
		return FALSE;
	}

	public function register() {
		add_action('init', array($this, "register_post_type"));

		SegmentEditor::getInstance()->register();
		SegmentEditorHelp::getInstance()->register();
		SegmentEditorMetaBoxes::getInstance()->register();
	}

	public function register_post_type() {
		// Set various pieces of text, $labels is used inside the $args array
		$labels = array(
			'name' => _x('Target Segments', 'post type general name', 'tma-webtools'),
			'singular_name' => _x('Target Segment', 'post type singular name', 'tma-webtools'),
			'menu_name' => _x('Target Segments', 'admin menu', 'tma-webtools'),
			'name_admin_bar' => _x('Target Segment', 'add new on admin bar', 'tma-webtools'),
			'add_new' => _x('Add New', 'book', 'tma-webtools'),
			'add_new_item' => __('Add New Target Segment', 'tma-webtools'),
			'new_item' => __('New Target Segment', 'tma-webtools'),
			'edit_item' => __('Edit Target Segment', 'tma-webtools'),
			'view_item' => __('View Target Segment', 'tma-webtools'),
			'all_items' => __('All Target Segments', 'tma-webtools'),
			'search_items' => __('Search Target Segments', 'tma-webtools'),
			'parent_item_colon' => __('Parent Target Segments:', 'tma-webtools'),
			'not_found' => __('No Target Segments found.', 'tma-webtools'),
			'not_found_in_trash' => __('No Target Segments found in Trash.', 'tma-webtools')
		);

		// Set various pieces of information about the post type
		$args = array(
			'labels' => $labels,
			'description' => __("Target Segment", "tma-webtools"),
			'public' => true,
			'show_in_menu' => true,
			'menu_icon' => plugins_url('experience-manager/images/audience_16.png'),
			'publicly_queryable' => false,
			//'rewrite'            => array( 'slug' => 'targetaudience' ),
			'supports' => array('title', 'custom-fields'),
			'menu_position' => 51,
			'has_archive' => false,
			'hierarchical' => false
		);

		// Register the movie post type with all the information contained in the $arguments array
		register_post_type(SegmentType::$TYPE, $args);
	}

}
