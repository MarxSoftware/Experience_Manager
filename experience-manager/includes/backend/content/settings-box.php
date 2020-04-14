<div class="exm-content-editor">
	<input type="hidden" name="exm_content_settings" id="exm_content_settings" />
	<div class="tab-container">
		<div class="tab">
			<button class="tablinks" data-exm-tab-default="true" data-exm-tab-target="exm_settings_default" >Default</button>
			<button class="tablinks" data-exm-tab-target="exm_settings_recommendation">Recommendations</button>
			<button class="tablinks" data-exm-tab-target="exm_settings_popup">Popup</button>
			<button class="tablinks" data-exm-tab-target="exm_settings_conditions">Display Conditions</button>
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
							<th scope="row">
								<label for="exm_recommendation_type">Recommendation type</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_recommendation_type" name="exm_recommendation_type">
									<option value="recently_viewed">Recently viewed</option>
									<option value="frequently_purchased">Frequently purchased</option>
									<option value="popular">Popular products</option>
									<option value="bought_together">Bought together</option>
									<option value="similar_user">Similar user</option>
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
			<div id="exm_settings_popup" class="tabcontent">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="exm_popup_position">Position</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_popup_position" name="exm_popup_position">
									<option value="tl">Top left</option>
									<option value="tc">Top center</option>
									<option value="tr">Top right</option>
									<option value="ml">Middle left</option>
									<option value="mc">Middle center</option>
									<option value="mr">Middle right</option>
									<option value="bl">Bottom left</option>
									<option value="bc">Bottom center</option>
									<option value="br">Bottom right</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_popup_animation">Animation</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_popup_animation" name="exm_popup_animation">
									<option value="fade">Fade</option>
									<option value="slide">Slide</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_popup_trigger">Trigger</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_popup_trigger" name="exm_popup_trigger">
									<option value="5seconds">After 5 seconds</option>
									<option value="exitintend">Exit intent</option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="exm_settings_conditions" class="tabcontent">
				<h3>bald erhältlich</h3>
			</div>
		</div>	
	</div>

</div>
