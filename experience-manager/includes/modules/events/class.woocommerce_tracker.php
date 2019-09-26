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
 * Tracking of WooCommerce events.
 */
class WC_TRACKER {

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
		return isset($this->options['wc_tracking']) && $this->options['wc_tracking'] === "on";
	}

	public function init() {
		add_action('woocommerce_order_status_changed', array($this, 'woocommerce_order_status_changed'), 10, 3);

		add_action('woocommerce_add_to_cart', array($this, 'woocommerce_add_to_cart'));
		add_action('woocommerce_remove_cart_item', array($this, 'woocommerce_remove_cart_item'));
	}

	public function woocommerce_add_to_cart($cart_item_key) {
		$cart = WC()->cart;
		$item = $cart->get_cart_item($cart_item_key);

		// loop through the cart looking 
		$product_ids = array();
		foreach ($cart->get_cart() as $item_key => $values) {
			$product_ids[] = $values['product_id'];
		}

		$customAttributes = array();
		$customAttributes['item_id'] = $item['product_id'];
		$customAttributes['cart_items'] = $product_ids; //implode(":", $product_ids);
		$request = new \TMA\TMA_Request();
		$request->track("ecommerce_cart_item_add", "#cart", $customAttributes);
	}

	public function woocommerce_remove_cart_item($cart_item_key) {
		$cart = WC()->cart;
		$item = $cart->get_cart_item($cart_item_key);

		// loop through the cart looking 
		$product_ids = array();
		foreach ($cart->get_cart() as $item_key => $values) {
			if ($cart_item_key === $item_key) {
				continue;
			}
			$product_ids[] = $values['product_id'];
		}

		$customAttributes = array();
		$customAttributes['item_id'] = $item['product_id'];
		$customAttributes['cart_items'] = $product_ids; //implode(":", $product_ids);
		$request = new \TMA\TMA_Request();
		$request->track("ecommerce_cart_item_remove", "#cart", $customAttributes);
	}

	public function woocommerce_order_status_changed($order_id, $status_from, $status_to) {
		$order = new \WC_Order($order_id);
		$items = $order->get_items();
		$product_ids = array();
		foreach ($items as $item => $product) {
			$product_ids[] = $product['product_id'];
		}
		$request = new \TMA\TMA_Request();
		$customAttributes = array();
		$customAttributes['order_id'] = $order_id;
		$customAttributes['order_items'] = $product_ids;
		$customAttributes['order_status'] = $order->get_status();
		$customAttributes['order_total'] = $order->get_total();

		if ($order->get_used_coupons()) {
			$coupons_count = count($order->get_used_coupons());
			
			$coupons_used = array();
			foreach ($order->get_used_coupons() as $coupon) {
				$coupons_used[] = $coupon;
			}
			
			$customAttributes['order_coupons_count'] = $coupons_count;
			$customAttributes['order_coupons_used'] = $coupons_used;
		}

		$request->track("ecommerce_order", "#order", $customAttributes);
	}

}
