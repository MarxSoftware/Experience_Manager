<div class="ui modal" id="exm_audience_wizard">
	<i class="close icon"></i>
	<div class="header">Create basic segment</div>
	<div class="scrolling content">
		<div class="ui form">
			<h4 class="ui dividing header">Visit</h4>
			<div class="inline fields">
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_visit" value="any" tabindex="0" class="hidden" checked="">
						<label>Any</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_visit" value="first" tabindex="0" class="hidden">
						<label>First visit</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_visit" value="returning" tabindex="0" class="hidden">
						<label>Returning visitor</label>
					</div>
				</div>
			</div>
			<h4 class="ui dividing header">Device</h4>
			<div class="inline fields">
				<div class="field">
					<div class="ui toggle checkbox">
						<input type="checkbox" tabindex="0" class="hidden" name="exm_device_mobile" >
						<label>Mobile</label>
					</div>
				</div>
				<div class="field">
					<div class="ui toggle checkbox">
						<input type="checkbox" tabindex="0" class="hidden" name="exm_device_tablet" >
						<label>Tablet</label>
					</div>
				</div>
				<div class="field">
					<div class="ui toggle checkbox">
						<input type="checkbox" tabindex="0" class="hidden" name="exm_device_desktop" >
						<label>Desktop</label>
					</div>
				</div>
			</div>
			<h4 class="ui dividing header">e-Commerce</h4>
			<h6 class="ui horizontal divider header">
				Purchases
			</h6>
			<div class="ui info message">
				Select the amount of <b>purchases</b> for segmentation. <b>Active customer</b> means 3 or more purchases.
			</div>
			<div class="inline fields">
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_order" value="any" tabindex="0" class="hidden" checked="">
						<label>Any</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_order" value="none" tabindex="0" class="hidden">
						<label>No purchase yet</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_order" value="first" tabindex="0" class="hidden">
						<label>First purchaser</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_order" value="active" tabindex="0" class="hidden">
						<label>Active customer</label>
					</div>
				</div>
			</div>
			<h6 class="ui horizontal divider header">
				Discount / Coupons
			</h6>
			<div class="ui info message">
				Select the amount of <b>coupons</b> for segmentation. <b>Coupon lovers</b> means 1 or more coupons used in the past.
			</div>
			<div class="inline fields">
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_coupon" value="any" tabindex="0" class="hidden" checked="">
						<label>Any</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_coupon" value="none" tabindex="0" class="hidden">
						<label>No coupon used</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_coupon" value="lover" tabindex="0" class="hidden">
						<label>Coupon lovers</label>
					</div>
				</div>
			</div>
			<h6 class="ui horizontal divider header">
				Average Order Value
			</h6>
			<div class="ui info message">
				Use the <b>Average Order Value</b> for segmentation. <b>Big Spender</b> spend on average 200% of the average. <b>Thrifty</b> people spend only 50% of the average.
			</div>
			<div class="inline fields">
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_aov" value="any" tabindex="0" class="hidden" checked="">
						<label>Any</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_aov" value="big_spender" tabindex="0" class="hidden">
						<label>Big Spender</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_aov" value="thrifty" tabindex="0" class="hidden">
						<label>Thrifty</label>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="actions">
		<div class="ui black deny button">
			Cancle
		</div>
		<div class="ui positive right labeled icon button">
			Create segment
			<i class="checkmark icon"></i>
		</div>
	</div>
</div>
<script>
	jQuery(function () {
		jQuery('.ui.checkbox').checkbox();
	});

</script>