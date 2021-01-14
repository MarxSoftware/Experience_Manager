<h1>Dashboard</h1>
<div id="webtools" class="webtools-dashboard">
	<div class="grid-container">
		<main class="main">

			<div class="main-header">
				<div id="chart"></div>
			</div>

			<h2>Metrics</h2>
			<div class="main-overview">
				<div class="overviewcard">
					<div class="overviewcard_title">
						<h2>Unique user</h2>
					</div>
					<div class="overviewcard_content">
						<div class="lds-dual-ring" id="exm_unique_users_loader"></div>
						<div id="unique_users" class="number"></div>
					</div>
				</div>
				<div class="overviewcard">
					<div class="overviewcard_title">
						<h2>Requests per visit</h2>
					</div>
					<div class="overviewcard_content">
						<div class="lds-dual-ring" id="exm_pageviews_per_visit_loader"></div>
						<div id="pageviews_per_visit" class="number"></div>
					</div>
				</div>
			</div>
			<?php 
				if (\TMA\ExperienceManager\Plugins::getInstance()->woocommerce() || \TMA\ExperienceManager\Plugins::getInstance()->easydigitaldownloads())  {
			?>
			<h2>eCommerce-Metrics</h2>
			<div class="main-overview">
				
				<div class="overviewcard">
					<div class="overviewcard_title">
						<h2>Order conversion</h2>
					</div>
					<div class="overviewcard_content">
						<div class="lds-dual-ring" id="exm_order_conversion_chart_loader"></div>
						<div id="order_conversion_chart"></div>
					</div>
				</div>
				
				<div class="overviewcard">
					<div class="overviewcard_title">
						<h2>Orders per user</h2>
					</div>
					<div class="overviewcard_content">
						<div class="lds-dual-ring" id="exm_orders_per_user_loader"></div>
						<div id="orders_per_user" class="number"></div>
					</div>
				</div>
				
				<div class="overviewcard">
					<div class="overviewcard_title">
						<h2>Cart abandoned rate</h2>
					</div>
					<div class="overviewcard_content">
						<div class="lds-dual-ring" id="exm_cart_abandoned_rate_loader"></div>
						<div id="cart_abandoned_rate" ></div>
					</div>
				</div>
			</div>
			<?php 
				}
			?>
			<!--div class="main-cards">
				<div class="card">Card 1</div>
				<div class="card">Card 2</div>
				<div class="card">Card 2</div>
				<div class="card">Card 2</div>
				<div class="card">Card 3</div>
			</div-->
			
		</main>
	</div>
</div>