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
 * Description of TMAScriptHelper
 *
 * @author marx
 */
class TMAScriptHelper {

	public function isTrackingEnabled() {

		$trackUser = false;
		if (isset(get_option('tma_webtools_option')['webtools_track_logged_in_users']) && get_option('tma_webtools_option')['webtools_track_logged_in_users'] == true) {
			$trackUser = true;
		} else {
			$trackUser = !is_user_logged_in();
		}

		if (function_exists('vc_is_frontend_editor') && vc_is_frontend_editor()) {
			return false;
		} else if (function_exists('siteorigin_panels_is_preview') && siteorigin_panels_is_preview()) {
			return false;
		} else if (is_preview()) {
			return false;
		}



		return isset(get_option('tma_webtools_option')['webtools_track']) && get_option('tma_webtools_option')['webtools_track'] == true && $trackUser && isset(get_option('tma_webtools_option')['webtools_url']) && get_option('tma_webtools_option')['webtools_url'];
	}

	/**
	 * check if scoreing is enabled and a single post or page is shown.
	 * 
	 * @return type
	 */
	public function shouldScore() {
		return isset(get_option('tma_webtools_option')['webtools_score']) && get_option('tma_webtools_option')['webtools_score'] && (is_single() || is_page());
	}

	public function getLibrary() {
		//return '<script src="' . $this->getWebTools_Url() . '/js/webtools.js"></script>';
		return $this->getWebTools_Url() . '/tracking/js/webtools.js';
	}

	private function getWebTools_Url() {
		$url = get_option('tma_webtools_option')['webtools_url'];
		return rtrim($url, "/");
	}

	public function getCode() {
		$output = '';
		if ($this->isTrackingEnabled()) {

			$siteid = get_option('blogname');
			if (isset(get_option('tma_webtools_option')['webtools_siteid'])) {
				$siteid = get_option('tma_webtools_option')['webtools_siteid'];
			}
			$cookieDomain = null;
			if (isset(get_option('tma_webtools_option')['webtools_cookiedomain'])) {
				$cookieDomain = get_option('tma_webtools_option')['webtools_cookiedomain'];

				$query = ".";
				if (substr($cookieDomain, 0, strlen($query)) !== $query) {
					$cookieDomain = "." . $cookieDomain;
				}
			}



			//$output .= $this->getLibrary();
			//$output .= '<script>';

			$meta = [];

			$this->add_meta($meta);
			$this->add_categories($meta);


			$meta = apply_filters('tma-webtools/customparameters', $meta);

			$customParameters = json_encode($meta);

			/*
			 * TODO: hier bin ich nicht genau sicher, wie wir is_home und is_front_page handeln sollen
			 * 
			 * is_home			= Blog Index
			 * is_front_page	= Die statische Seite, die als FrontPage definiert wurde
			 * 
			 * Wenn die Einstellungen auf default bleiben, sind beide TRUE
			 */
			/* if (is_home()) {
			  $output .= 'webtools.Tracking.init("' . $this->getWebTools_Url() . '", "' . $siteid . '", "/");';
			  } else */if (!is_404()) {
				$output .= 'webtools.Tracking.init("' . $this->getWebTools_Url() . '", "' . $siteid . '", "' . (get_post()->post_type . '%23' . get_post()->post_name) . '");';
			} else {
				$output .= 'webtools.Tracking.init("' . $this->getWebTools_Url() . '", "' . $siteid . '", "404");';
			}
			if ($cookieDomain !== null) {
				$output .= 'webtools.Tracking.setCookieDomain("' . $cookieDomain . '");';
			}
			$output .= 'webtools.Tracking.customParameters(';
			$output .= $customParameters;
			$output .= ');';
			$output .= 'webtools.Tracking.register();';

			if ($this->shouldScore()) {
				$score = $this->getScoring();

				$output .= $score;
			}


			//$output .= '</script>';
		}

		return $output;
	}

	private function add_meta(& $meta) {
		/*
		 * TODO: siehe oben, evtl. sollte hier noch etwas gemacht werden.
		 */
		$meta['home'] = is_home();
		$meta['front_page'] = is_front_page();
		if (is_category()) {
			$meta['taxonomy'] = get_the_category()[0]->taxonomy;
			$meta['archiv'] = true;
			$meta['slug'] = get_the_category()[0]->slug;
		} else if (function_exists("is_product_category") && is_product_category()) {
			$term = get_queried_object();
			$meta['taxonomy'] = $term->taxonomy;
			$meta['archiv'] = true;
			$meta['slug'] = $term->slug;
		} else if (!is_404()) {
			$meta['post_type'] = get_post()->post_type;
			$meta['slug'] = get_post()->post_name;
			$meta['archiv'] = false;
		}
	}

	private function add_categories(& $meta) {
		$cats = [];
		if (is_category()) {
			$term_list = get_categories();
			foreach ($term_list as $cat) {
				//$cats[] = $cat->slug;
				$cats[] = "/" . get_term_parents_list($cat->term_id, "category", ["format" => "slug", "link" => false]);
			}
		} else if (function_exists("is_product_category") && is_product_category()) {
			$term = get_queried_object();
			//$cats[] = $term->slug;
			$cats[] = "/" . get_term_parents_list($term->term_id, "product_cat", ["format" => "slug", "link" => false]);
		} else if (function_exists("is_product") && is_product()) {
			$product = wc_get_product();
			$term_list = get_the_terms($product->get_id(), 'product_cat');
			foreach ($term_list as $cat) {
				//$cats[] = $cat->slug;
				$cats[] = "/" . get_term_parents_list($cat->term_id, "product_cat", ["format" => "slug", "link" => false]);
			}
		} else if (!is_404()) {
			$post_categories = wp_get_post_categories(get_post()->ID, ['fields' => "ids"]);
			foreach ($post_categories as $cat) {
				$category = get_category($cat);
				//$cats[] = $category->slug;
				$cats[] = "/" . get_term_parents_list($category->term_id, "category", ["format" => "slug", "link" => false]);
			}
		} else {
//			$taxomony = get_query_var( 'taxonomy' );
//			$term = get_term_by( 'slug', get_query_var( 'term' ), $taxomony ); 
		}

		if (sizeof($cats) > 0) {
			$meta['categories'] = array_map("strval", $cats);
		}
	}

	function getScoring() {
		$score = '{';
		$hasScore = false;
		//$custom_field_keys = get_post_custom_keys();

		$metaData = get_post_meta(get_the_ID(), Constants::$META_KEY_SEGMENT_SCORE);
		$segments = array();
		if (isset($metaData[0])) {
			$segments = $metaData[0];
		}
		if ($segments != null) {
			foreach ($segments as $key => $value) {
				if ($hasScore) {
					$score .= ', ';
				}
				$scoreValue = $value; //array_values(get_post_custom_values($value))[0];
				$value = str_replace('tma_score_', '', $value);
				$score .= $key . ' : ' . $scoreValue;
				$hasScore = true;
			}
		}

		$score .= '}';
		if ($hasScore) {
			return 'webtools.Tracking.score(' . $score . ');';
		} else {
			return '';
		}
	}

	public static function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}

}
