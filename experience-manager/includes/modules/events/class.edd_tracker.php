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

namespace TMA\ExperienceManager\Events;

/**
 * Tracking of WooCommerce events.
 */
class EDD_TRACKER extends Base {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	protected function __construct() {
		$this->options = get_option('tma-webtools-events');
	}

	public function shouldInit() {
		return isset($this->options['edd_tracking']) && $this->options['edd_tracking'] === "on";
	}
	
	public function init() {
		tma_exm_log("init edd tracking");
		add_action('edd_update_payment_status', array($this, 'order_status_changed'), 10, 3);
		add_action('edd_post_add_to_cart', array($this, 'add_to_cart'), 10, 3);
		add_action('edd_post_remove_from_cart', array($this, 'remove_cart_item'), 10, 2);
	}

	public function add_to_cart($download_id, $options, $items) {
		tma_exm_log("edd ecommerce_cart_item_add");
		$cart = EDD()->cart;
//		$item = $cart->get_contents();
		// loop through the cart looking 
		$product_ids = array();
		foreach ($items as $key => $item) {
			$product_ids[] = $item['id'];
		}

		$customAttributes = array();
		$customAttributes['item_id'] = $download_id;
		$customAttributes['cart_items'] = $product_ids; //implode(":", $product_ids);
		$request = new \TMA\ExperienceManager\TMA_Request();
		$request->track("ecommerce_cart_item_add", "#cart", $customAttributes);
	}

	public function remove_cart_item($key, $item_id ) {
		tma_exm_log("edd remove_cart_item");
		$cart = EDD()->cart;
		$item = $cart->get_contents();

		// loop through the cart looking 
		$product_ids = array();
		foreach ($items as $key => $item) {
			if ($item_id === $item["id"]) {
				continue;
			}
			$product_ids[] = $item['id'];
		}

		$customAttributes = array();
		$customAttributes['item_id'] = $item_id;
		$customAttributes['cart_items'] = $product_ids; //implode(":", $product_ids);
		$request = new \TMA\ExperienceManager\TMA_Request();
		$request->track("ecommerce_cart_item_remove", "#cart", $customAttributes);
	}

	public function order_status_changed($order_id, $status_from, $status_to) {

		if ($this->has_order_been_tracked_already($order_id)) {
			tma_exm_log(sprintf('Ignoring already tracked order %d', $order_id));
			return;
		}
		tma_exm_log("track edd order " . $order_id);

		$order = new \EDD_Payment($order_id);
		$product_ids = array();
		
		$cart = edd_get_payment_meta_cart_details($order_id, true);
		if ($cart) {
			foreach ($cart as $key => $item) {
				if (empty($item['in_bundle'])) {
					$download = new \EDD_Download($item['id']);
					$product_ids[] = $download->get_ID();
				}
			}
		}
		
		$request = new \TMA\ExperienceManager\TMA_Request();
		$customAttributes = array();
		$customAttributes['order_id'] = $order_id;
		$customAttributes['order_items'] = $product_ids;
		$customAttributes['order_total'] = $order->total;

		$request->track("ecommerce_order", "#order", $customAttributes);
	}

}
