<?php

namespace TMA\ExperienceManager\Events;

class Base {
	
	protected $key_order_tracked = 'exm-order-tracked';
	
	protected function has_order_been_tracked_already( $order_id ) {
		return get_post_meta( $order_id, $this->key_order_tracked, true ) == 1;
	}
	protected function set_order_been_tracked( $order_id ) {
		update_post_meta( $order_id, $this->key_order_tracked, 1 );
	}
}