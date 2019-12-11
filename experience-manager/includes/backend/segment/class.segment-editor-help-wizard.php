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
						<label>None purchase yet</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_order" value="first" tabindex="0" class="hidden">
						<label>First Purchaser</label>
					</div>
				</div>
				<div class="field">
					<div class="ui radio checkbox">
						<input type="radio" name="exm_order" value="active" tabindex="0" class="hidden">
						<label>Active customer</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui black deny button">
			Nope
		</div>
		<div class="ui positive right labeled icon button">
			Yep, that's me
			<i class="checkmark icon"></i>
		</div>
	</div>
</div>
<script>
	jQuery(function () {
		jQuery('.ui.checkbox').checkbox();
	});

</script>