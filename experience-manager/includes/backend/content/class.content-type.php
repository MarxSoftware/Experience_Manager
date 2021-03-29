<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Content;

/**
 * Description of class
 *
 * @author marx
 */
class ContentType {

	public static $TYPE = "exm_content";

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
	static function isContentEditor() {
		$screen = get_current_screen();
		if (is_object($screen) && ContentType::$TYPE === $screen->post_type) {
			return TRUE;
		}
		return FALSE;
	}

	public function register() {
		add_action('init', array($this, "register_post_type"));

		add_action(
				'edit_form_after_title',
				array(
					$this,
					'edit_form_below_title',
				)
		);

		ContentEditor::getInstance()->register();
		ContentEditorMetaBox::getInstance()->register();
		ContentSettingsMetaBox::getInstance()->register();
		ContentShortCode::getInstance()->register();
		ContentAjax::getInstance()->register();
	}

	public function edit_form_below_title($post) {
		if (!isset($post->post_type) || $post->post_type !== ContentType::$TYPE) {
			return;
		}

		include 'info.php';
	}

	public function register_post_type() {
		// Set various pieces of text, $labels is used inside the $args array
		$labels = array(
			'name' => _x('Flex content', 'post type general name', 'experience-manager'),
			'singular_name' => _x('Flex Content', 'post type singular name', 'experience-manager'),
			'menu_name' => _x('Flex Contents', 'admin menu', 'experience-manager'),
			'name_admin_bar' => _x('Flex Content', 'add new on admin bar', 'experience-manager'),
			'add_new' => _x('Add New', 'book', 'experience-manager'),
			'add_new_item' => __('Add New Flex Content', 'experience-manager'),
			'new_item' => __('New Flex Content', 'experience-manager'),
			'edit_item' => __('Edit Flex Content', 'experience-manager'),
			'view_item' => __('View Flec Content', 'experience-manager'),
			'all_items' => __('All Flex Contents', 'experience-manager'),
			'search_items' => __('Search Flex Contentx', 'experience-manager'),
			'parent_item_colon' => __('Parent Flex Contents:', 'experience-manager'),
			'not_found' => __('No Flex Contents found.', 'experience-manager'),
			'not_found_in_trash' => __('No Flex Contents found in Trash.', 'experience-manager')
		);

		// Set various pieces of information about the post type
		$args = array(
			'labels' => $labels,
			'description' => __("Flex Content", "experience-manager"),
			'public' => true,
			'show_in_menu' => true,
			'menu_icon' => plugins_url('experience-manager/images/flex-content_16.png'),
			'publicly_queryable' => false,
			'supports' => array('title'),
			'menu_position' => 51,
			'has_archive' => false,
			'hierarchical' => true
		);

		// Register the movie post type with all the information contained in the $arguments array
		register_post_type(ContentType::$TYPE, $args);
	}

}
