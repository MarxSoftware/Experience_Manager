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

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		$this->options = get_option('tma-webtools-events');
	}

	public function shouldInit() {
		return isset($this->options['edd_tracking']) && $this->options['edd_tracking'] === "on";
	}

	public function init() {
		tma_exm_log("init edd tracking");
		add_action('edd_update_payment_status', array($this, 'order_status_changed'), 10, 3);
		add_action('edd_payment_receipt_after_table', array($this, 'on_order'), 10, 3);


		add_action('edd_post_add_to_cart', array($this, 'add_to_cart'), 10, 3);

		add_action('edd_post_remove_from_cart', array($this, 'remove_cart_item'), 10, 2);

		add_action('wp_ajax_edd_remove_from_cart', [$this, 'edd_ajax_remove_from_cart']);
		add_action('wp_ajax_nopriv_edd_remove_from_cart', [$this, 'edd_ajax_remove_from_cart']);
	}

	public function edd_ajax_remove_from_cart() {
		tma_exm_log("edd_ajax_remove_from_cart");
	}

	public function on_order($payment, $edd_receipt_args) {
		if ($this->has_order_been_tracked_already($payment->ID)) {
			tma_exm_log(sprintf('Ignoring already tracked order %d', $payment->ID));
			return;
		}
		tma_exm_log("track edd order (on_order)" . $payment->ID);

		$product_ids = array();
		
		$order = new \EDD_Payment($payment->ID);
//		$items = $order->get_downloads();
//		$product_ids = array();
//		foreach ($items as $item => $product) {
//			$product_ids[] = $product->get_ID();
//		}

		
		$cart = edd_get_payment_meta_cart_details($payment->ID, true);
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
		$customAttributes['order_id'] = $order->ID;
		$customAttributes['order_items'] = $product_ids;
		//$customAttributes['order_status'] = $order->get_status();
		$customAttributes['order_total'] = sizeof($product_ids);

		$request->track("ecommerce_order", "#order", $customAttributes);
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

	public function remove_cart_item($download_id, $options) {
		tma_exm_log("edd remove_cart_item");
		$cart = EDD()->cart;
		$item = $cart->get_contents();

		// loop through the cart looking 
		$product_ids = array();
		foreach ($items as $key => $item) {
			if ($download_id === $item["id"]) {
				continue;
			}
			$product_ids[] = $item['id'];
		}

		$customAttributes = array();
		$customAttributes['item_id'] = $download_id;
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
		$items = $order->get_downloads();
		$product_ids = array();
		foreach ($items as $item => $product) {
			$product_ids[] = $product->get_ID();
		}
		$request = new \TMA\ExperienceManager\TMA_Request();
		$customAttributes = array();
		$customAttributes['order_id'] = $order_id;
		$customAttributes['order_items'] = $product_ids;
		$customAttributes['order_status'] = $order->get_status();
		$customAttributes['order_total'] = $order->get_total();

		$request->track("ecommerce_order", "#order", $customAttributes);
	}

}
