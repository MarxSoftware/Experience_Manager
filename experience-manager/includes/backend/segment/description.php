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
			Your segment definition must start with: <b>segment().site(&quot;<?php echo $siteid; ?>&quot;)</b>
		</p>
		<p>
			Then a segment definition is simply a sequence of rules linked by AND, OR or NOT.
			<br/> 
			<i>segment().site(&quot;<?php echo $siteid; ?>&quot;).<b>and</b>(&lt;rules&gt;)</i>
			<br/> 
			<i>segment().site(&quot;<?php echo $siteid; ?>&quot;).<b>or</b>(&lt;rules&gt;)</i>
			<br/> 
			<i>segment().site(&quot;<?php echo $siteid; ?>&quot;).<b>not</b>(&lt;rules&gt;)</i>
		</p>
	</div>

	<h3>Rules</h3>
	<div>
		<p>
			<span class="headline">AND</span>
			<br />
			All nested rules must match.
			<br />
			<b>and(&lt;list of rules&gt;)</b>
		</p>
		<p>
			<span class="headline">OR</span>
			<br />
			One of the nested rules must match.
			<br />
			<b>or(&lt;list of rules&gt;)</b>
		</p>
		<p>
			<span class="headline">NOT</span>
			<br />
			None of the nested rules must match.
			<br />
			<b>not(&lt;list of rules&gt;)</b>
		</p>
		<p>
			<span class="headline">PAGEVIEW</span>
			<br />
			Test if a user has viewed a specific page or posttype. By confention use &lt;posttype&gt;#&lt;slug&gt;
			<br />
			<b>rule(PAGEVIEW)</b>
			<br />
			<span class="subheadline">Examples</span><br/>
			<span>User has visited the homepage: </span><b>.rule(PAGEVIEW).page('the id').type('page').count(1)</b>
			<br />
			<span>User has visited a product page: </span><b>.rule(PAGEVIEW).page('the id').type('product').count(1)</b>
		</p>
		<p>
			<span class="headline">EVENT</span>
			<br />
			A specific event. See <a href="#events">Events Section</a> for all tracked events.
			<br />
			<b>rule(EVENT)</b>
			<br />
			<span class="subheadline">Examples</span><br/>
			<span>User has visited at least two page: </span><b>rule(EVENT).event("pageview").count(2)</b>
		</p>
		<p>
			<span class="headline">FIRSTVISIT</span>
			<br />
			Check if it is the first visit of a customer.
			<br />
			<b>rule(FIRSTVISIT)</b>
		</p>
		<p>
			<span class="headline">CATEGORY</span>
			<br />
			Check if a user has visited posts or products of a specific category.
			User the category path generator to get the correct path: <a href="#exm_categories">Category path generator</a>
			<br />
			<b>rule(CATEGORY).field('c_categories')</b>
			<br />
			<span class="subheadline">Examples</span><br/>
			<span>User has visited at least two post of a category: </span><b>rule(CATEGORY).path('/news/local').field('c_categories').count(2)</b>
			<br/>
			<span>User has visited at least two products of the category T-Shirts: </span><b>rule(CATEGORY).path('/tshirts/').field('c_categories').count(2)</b>
		</p>
		<p>
			<span class="headline">KEYVALUE</span>
			<br />
			The KeyValue-Rule is a generic rule that is used for many purposes.			
			<br />
			<b>rule(KEYVALUE).name('browser.name').values(['Chrome', 'Firefox'])</b>
			<br />
			"browser.name" (e.g. Chrome, Firefox, Edge, Safari) <br/>
			"device.type" (e.g. Mobile Phone, Desktop, Tablet, Console, TV Device) <br/>
			<span class="subheadline">Examples</span><br/>
			<span>User uses firefox or chrome browser: </span><b>rule(KEYVALUE).name('browser.name').values(['Chrome', 'Firefox'])</b>
			<br/>
			<span>User uses a desktop pc: </span><b>rule(KEYVALUE).name('device.type').values(['Desktop'])</b>
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
