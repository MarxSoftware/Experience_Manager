<div class="exm-content-editor">
	<input type="hidden" name="exm_content_settings" id="exm_content_settings" />
	<div class="tab-container">
		<div class="tab">
			<button class="tablinks" data-exm-tab-default="true" data-exm-tab-target="exm_settings_default" >Default</button>
			<button class="tablinks" data-exm-tab-target="exm_settings_recommendation">Recommendations</button>
			<!--<button class="tablinks" data-exm-tab-target="exm_settings_popup">Popup</button>-->
			<!--<button class="tablinks" data-exm-tab-target="exm_settings_conditions">Display Conditions</button>-->
		</div>
		<div class="tab-content">
			<div id="exm_settings_default" class="tabcontent">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="exm_content_type">Content type</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_content_type" name="exm_content_type">
									<option value="simple_content">Simple Content</option>
									<option value="popup" >Popup</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">Enable shortcodes</th>
							<td>
								<fieldset>
									<label for="exm_shortcode">
										<input id="exm_shortcode" class="exm_settings_change" value="true" name="exm_shortcode" type="checkbox" />Enable shortcodes
									</label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th scope="row">Loading animation</th>
							<td>
								<fieldset>
									<label for="exm_content_loading_animation">
										<input type="checkbox" value="true" class="exm_settings_change" id="exm_content_loading_animation" name="exm_content_loading_animation"> Display loading animation
									</label>
									<br />
									<label for="exm_content_loading_animation_color">
										<input id="exm_content_loading_animation_color" class="exm_settings_change" value="#000000" name="exm_content_loading_animation_color" type="color" /> Color of the loading animation
									</label>
								</fieldset>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="exm_settings_recommendation" class="tabcontent">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">Insert recommendations</th>
							<td>
								<fieldset>
									<label for="exm_recommendation">
										<input id="exm_recommendation" class="exm_settings_change" value="true" name="exm_recommendation" type="checkbox" /> Enable recommendations
									</label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_recommendation_type">Recommendation type</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_recommendation_type" name="exm_recommendation_type">
									<option value="recently-viewed">Recently viewed</option>
									<option value="frequently-purchased">Frequently purchased</option>
									<option value="popular">Popular products</option>
									<option value="bought-together">Bought together</option>
									<option value="similar-user">Similar user</option>
									<option value="most-viewed">Most viewed</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_recommendation_resolution">Recommendation resolution</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_recommendation_resolution" name="exm_recommendation_resolution">
									<option value="ALL" selected="selected">All</option>
									<option value="DAY">Day</option>
									<option value="WEEK">Week</option>
									<option value="MONTH">Month</option>
									<option value="YEAR">Year</option>
								</select>
							</td>
						</tr>
						
						<tr>
							<th scope="row">
								<label for="exm_recommendation_count">Number of recommendations</label>
							</th>
							<td>
								<input class="exm_settings_change" type="number" step="1" min="1" id="exm_recommendation_count" name="exm_recommendation_count">
								<br />
								<span class="description">The number of recommendated products.</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
	</div>

</div>
