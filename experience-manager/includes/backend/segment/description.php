<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div>
	<?php 
		$siteid = "";
		if (isset(get_option('tma_webtools_option')['webtools_siteid'])) {
			$siteid = get_option('tma_webtools_option')['webtools_siteid'];
		}
	?>
	<h2>Your Site id: <b><?php echo $siteid; ?></b></h2>
	<h3>Events</h3>
	<p>
		<h4>Default event</h4>
	</p>
	<p>
		<b>pageview</b>
		<br />
		A single pageview
	</p>
<p>
	<h4>ecommerce related events (rule(EVENT))</h4>
	<p>All events tracked for ecommerce</p>
	<p>
		<b>ecommerce_cart_item_add</b>
		<br/>
		Item added to cart.
	</p>
	<p>
		<b>ecommerce_cart_item_remove</b>
		<br/>
		Item removed from card
	</p>
	<p>
		<b>ecommerce_order</b><br/>
		Send order
	</p>
</p>
</div>
