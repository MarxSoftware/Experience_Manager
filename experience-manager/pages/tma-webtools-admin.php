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
?>
<h1>Dashboard</h1>
<div id="webtools">
	<div class="grid-container">
		<main class="main">

			<div class="main-header">
				<div id="chart"></div>
			</div>

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
				<!--
				<div class="overviewcard">
					<div class="overviewcard__icon">Overview</div>
					<div class="overviewcard__info">Card</div>
				</div>
				-->
			</div>
			<!--
			<div class="main-cards">
				<div class="card">Card 1</div>
				<div class="card">Card 2</div>
				<div class="card">Card 3</div>
			</div>
			-->
		</main>
	</div>
</div>