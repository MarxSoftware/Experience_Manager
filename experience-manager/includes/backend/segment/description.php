<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
	.tma_webtools span.headline {
		font-weight: bolder;
		text-decoration: underline;
	}
	.tma_webtools span.subheadline {
		font-weight: bold;
	}
</style>
<div class="tma_webtools">
	<?php
	$siteid = "";
	if (isset(get_option('tma_webtools_option')['webtools_siteid'])) {
		$siteid = get_option('tma_webtools_option')['webtools_siteid'];
	}
	?>
	<h2>Your Site id: <b><?php echo $siteid; ?></b></h2>
	<div>
		<p>
			The segment definition is basicly a list of conditionals, written in a simple JSON format.
		</p>
	</div>

	<h3>Conditionals</h3>
	<div>
		<p>
			<span class="headline">AND</span>
			<br />
			All nested rules must match.
			<br />
			<b>{ "conditional" : "and", "conditions" : [...]}</b>
		</p>
		<p>
			<span class="headline">OR</span>
			<br />
			One of the nested rules must match.
			<br />
			<b>{ "conditional" : "or", "conditions" : [...]}</b>
		</p>
		<p>
			<span class="headline">NOT</span>
			<br />
			None of the nested rules must match.
			<br />
			<b>{ "conditional" : "not", "conditions" : [...]}</b>
		</p>
		<p>
			<span class="headline">PageView</span>
			<br />
			Test if a user has viewed a specific page or posttype.
			<br />
			<b>{ "conditional" : "pageview" }</b>
			<br />
			<span class="subheadline">Examples</span><br/>
			<span>User has visited the homepage: </span><b>{ "conditional" : "pageview" , "page" : "page_id", "type" : "page", "count" : 1 }</b>
			<br />
			<span>User has visited a WooCommerce product page: </span><b>{ "conditional" : "pageview" , "page" : "product_id", "type" : "product", "count" : 1 }</b>
		</p>
		<p>
			<span class="headline">Event</span>
			<br />
			A specific event. See <a href="#events">Events Section</a> for all tracked events.
			<br />
			<b>{ "conditional" : "event" }</b>
			<br />
			<span class="subheadline">Examples</span><br/>
			<span>User has visited at least two page: </span><b>{ "conditional" : "event", "event" : "pageview", "count" : 2 }</b>
		</p>
		<p>
			<span class="headline">FirstVisit</span>
			<br />
			Check if it is the first visit of a customer.
			<br />
			<b>{ "conditional" : "firstvisit"}</b>
		</p>
		<p>
			<span class="headline">Category</span>
			<br />
			Check if a user has visited posts or products of a specific category.
			User the category path generator to get the correct path: <a href="#exm_categories">Category path generator</a>
			<br />
			<b>{ "conditional" : "category", "field" : "c_categories"}</b>
			<br />
			<span class="subheadline">Examples</span><br/>
			<span>User has visited at least two post of a category: </span><b>{ "conditional" : "category", "field" : "c_categories", "path" : "/news/local/", count: "2" }</b>
			<br/>
			<span>User has visited at least two products of the category T-Shirts: </span><b>{ "conditional" : "category", "field" : "c_categories", "path" : "/tshirts/", count: "2" }</b>
		</p>
		<p>
			<span class="headline">KeyValue</span>
			<br />
			The KeyValue-Rule is a generic rule that is used for many purposes.			
			<br />
			<b>{ "conditional" : "keyvalue"}</b>
			<br />
			"browser.name" (e.g. Chrome, Firefox, Edge, Safari) <br/>
			"device.type" (e.g. Mobile Phone, Desktop, Tablet, Console, TV Device) <br/>
			<span class="subheadline">Examples</span><br/>
			<span>User uses firefox or chrome browser: </span><b>{ "conditional" : "keyvalue", "name" : "browser.name", "values": ["Chrome", "Firefox"] }</b>
			<br/>
			<span>User uses a desktop pc: </span><b>{ "conditional" : "keyvalue", "name" : "device.type", "values": ["Desktop"] }</b>
		</p>
	</div>


	<a name="events"></a>
	<h3>Events</h3>
	<div>
		<p>
			<b>pageview</b>
			<br />
			A single pageview
		</p>
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
	</div>
</div>
