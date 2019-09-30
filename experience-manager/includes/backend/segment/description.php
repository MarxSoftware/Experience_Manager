<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
	.tma_webtools span.headline {
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
			<span class="headline">event</span>
			<br />
			A specific event. See <a href="#events">Events Section</a> for all tracked events.
			<br />
			<b>rule(EVENT)</b>
			<br>
			<span>example, user has visited at least one page: </span>rule(EVENT).event("pageview").count(1)
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
