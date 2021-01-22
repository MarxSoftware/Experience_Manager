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

		if (is_preview()) {
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

	private function getWebTools_Url() {
		$url = get_option('tma_webtools_option')['webtools_url'];
		return rtrim($url, "/");
	}

	public function getCode() {
		$output = '';
		if ($this->isTrackingEnabled() && !is_admin()) {

			$siteid = tma_exm_get_site();
			$cookieDomain = FALSE;
			if (isset(get_option('tma_webtools_option')['webtools_cookiedomain'])) {
				$cookieDomain = get_option('tma_webtools_option')['webtools_cookiedomain'];
				if ($cookieDomain !== '') {
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

			$output = "var _exm = window._exm || [];\r\n";
			$output .= "_exm.push(['init']);\r\n";
			$output .= "_exm.push(['setTrackerUrl', '{$this->getWebTools_Url()}']);\r\n";
			$output .= "_exm.push(['setSite', '$siteid']);\r\n";
			if (!is_404()) {
				$output .= "_exm.push(['setPage', '" . get_post()->ID . "']);\r\n";
				$output .= "_exm.push(['setType', '" . get_post()->post_type . "']);\r\n";
			} else {
				$output .= "_exm.push(['setPage', '404']);\r\n";
				$output .= "_exm.push(['setType', 'error']);\r\n";
			}

			$output .= "_exm.push(['setCustomParameters', $customParameters]);\r\n";
			if ($cookieDomain !== FALSE) {
				$output .= "_exm.push(['setCookieDomain', '$cookieDomain']);\r\n";
			}
			$output .= "(function() {\r\n";
			$output .= "var u='" . TMA_EXPERIENCE_MANAGER_URL . "assets/exm/tracker.js';\r\n";
			$output .= "var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];\r\n";
			$output .= "g.type='text/javascript'; g.async=true; g.defer=true; g.src=u; s.parentNode.insertBefore(g,s);\r\n";
			$output .= "})();\r\n";
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
		$category_path = [];
		$categories = [];
		$ecom_category_path = [];
		$ecom_categories = [];
		$ecom_categories_parents = [];
		$categories_parents = [];

		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if (is_category()) {
			$term_list = get_categories();
			foreach ($term_list as $cat) {
				$result = $this->custom_get_term_parents_list($cat->term_id, "category", []);
				$category_path[] = "/" . $result["list"];
				$categories[] = $cat->term_id;
				
				$categories_parents = array_merge($categories_parents, $result["parents"]);
			}
		} else if (function_exists("is_product_category") && is_product_category()) { // woocommerce category
			$term = get_queried_object();
			$result = $this->custom_get_term_parents_list($term->term_id, "product_cat", []);
			$ecom_category_path[] = "/" . $result["list"];
			$ecom_categories_parents = array_merge($ecom_categories_parents, $result["parents"]);
		} else if (function_exists("is_product") && is_product()) { // woocommerce product
			$product = wc_get_product();
			$term_list = get_the_terms($product->get_id(), 'product_cat');
			foreach ($term_list as $cat) {
				$result = $this->custom_get_term_parents_list($cat->term_id, "product_cat", []);

				$ecom_category_path[] = "/" . $result["list"];
				$ecom_categories[] = $cat->term_id;
				
				$ecom_categories_parents = array_merge($ecom_categories_parents, $result["parents"]);
			}
		} else if (get_post() && get_post()->post_type === "download") { // easy digital download
			$download = edd_get_download(get_post()->ID);

			$term_list = get_the_terms($download->ID, 'download_category');
			foreach ($term_list as $cat) {
				$result = $this->custom_get_term_parents_list($cat->term_id, "download_category", []);

				$ecom_category_path[] = "/" . $result["list"];
				$ecom_categories[] = $cat->term_id;
				
				$ecom_categories_parents = array_merge($ecom_categories_parents, $result["parents"]);
			}
		} else if ($term && $term->taxonomy === "download_category") {
			$term = get_queried_object();
			$result = $this->custom_get_term_parents_list($term->term_id, $term->taxonomy, []);

			$ecom_category_path[] = "/" . $result["list"];
			$ecom_categories[] = $term->term_id;
			
			$ecom_categories_parents = array_merge($ecom_categories_parents, $result["parents"]);
		} else if (!is_404()) {
			$post_categories = wp_get_post_categories(get_post()->ID, ['fields' => "ids"]);
			foreach ($post_categories as $cat) {
				$category = get_category($cat);
				$result = $this->custom_get_term_parents_list($category->term_id, "category", []);

				$category_path[] = "/" . $result["list"];
				$categories[] = $categories->term_id;
				
				$categories_parents = array_merge($categories_parents, $result["parents"]);
			}
		}

		if (sizeof($category_path) > 0) {
			$meta['categories_path'] = array_map("strval", $category_path);
		}
		if (sizeof($categories) > 0) {
			$meta['categories'] = array_map("strval", $categories);
		}
		if (sizeof($ecom_categories) > 0) {
			$meta['ecom_categories'] = array_map("strval", $ecom_categories);
		}
		if (sizeof($ecom_category_path) > 0) {
			$meta['ecom_categories_path'] = array_map("strval", $ecom_category_path);
		}
		if (sizeof($ecom_categories_parents) > 0) {
			$ecom_categories_parents = array_unique($ecom_categories_parents);
			$meta['ecom_categories_parents'] = array_map("strval", $ecom_categories_parents);
		}
		if (sizeof($categories_parents) > 0) {
			$categories_parents = array_unique($categories_parents);
			$meta['$categories_parents'] = array_map("strval", $categories_parents);
		}
	}

	private function custom_get_term_parents_list($term_id_param, $taxonomy, $args = array()) {
		$list = '';
		$parent_categories = [];
		$term = get_term($term_id_param, $taxonomy);

		if (is_wp_error($term)) {
			return $term;
		}

		if (!$term) {
			return $list;
		}

		$term_id = $term->term_id;

		$defaults = array(
			'format' => 'id',
			'separator' => '/',
			'inclusive' => true,
		);

		$args = wp_parse_args($args, $defaults);


		$parents = get_ancestors($term_id, $taxonomy, 'taxonomy');

		if ($args['inclusive']) {
			array_unshift($parents, $term_id);
		}

		foreach (array_reverse($parents) as $term_id) {
			$parent = get_term($term_id, $taxonomy);
			$key = ( 'slug' === $args['format'] ) ? $parent->slug : $parent->term_id;

			$list .= $key . $args['separator'];

			if ($term_id_param !== $term_id) {
				$parent_categories[] = $term_id;
			}
		}

		$result = [];
		$result["list"] = $list;
		$result["parents"] = $parent_categories;
		return $result;
	}

}
