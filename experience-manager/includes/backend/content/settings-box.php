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
						<tr>
							<th scope="row">
								<label for="exm_popup_cookie_name">Cookie name</label>
							</th>
							<td>
								<input type="text" class="exm_settings_change" id="exm_popup_cookie_name" name="exm_popup_cookie_name" />
								<br />
								<span class="description">The close cookie name, if this cookie is set, the popup will not be displayed again.</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_popup_cookie_lifetime">Cookie lifetime</label>
							</th>
							<td>
								<input type="number" class="exm_settings_change" id="exm_popup_cookie_lifetime" name="exm_popup_cookie_lifetime" />
								<br />
								<span class="description">The lifetime of the close cookie.</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_popup_cookie_lifetime_unit">Cookie lifetime unit</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_popup_cookie_lifetime_unit" name="exm_popup_cookie_lifetime_unit">
									<option value="day">Days</option>
									<option value="week">Weeks</option>
									<option value="month">Months</option>
								</select>
								<br />
								<span class="description">The close cookie lifetime unit.</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="exm_settings_conditions" class="tabcontent">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="exm_condition_post_type">Display only on post types</label>
							</th>
							<td>
								<label>
									<button class="button" onclick='exm_content_settings_check_all("[name=exm_condition_post_type]"); return false;'><?php echo __("All post types", "tma-webtools") ?></button>
								</label>
								<?php
								$post_types = get_post_types([
									"public" => true,
									//"publicly_queryable" => true,
									"exclude_from_search" => false
										], "objects", "and");
								$filtered_types = ["media", \TMA\ExperienceManager\Content\ContentType::$TYPE, TMA\ExperienceManager\Segment\SegmentType::$TYPE];
								$post_types = array_filter($post_types, function ($element) use ($filtered_types) { 
									return !in_array($element->name, $filtered_types);
									
								}); 
								foreach ($post_types as $post_type) {
									?>
									<label>
										<input type="checkbox" class="exm_settings_change" name="exm_condition_post_type" value="<?php echo $post_type->name; ?>" />
										<?php echo $post_type->label; ?>
									</label>
									<?php
								}
								?>
								<br />
								<span class="description">Display popup just on these post types.</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_condition_audiences">Audiences</label>
							</th>
							<td>
								<label>
									<button class="button" onclick='exm_content_settings_check_all("[name=exm_condition_audiences]"); return false;'><?php echo __("All audiences", "tma-webtools") ?></button>
								</label>
								<?php
								$audiences = tma_exm_get_segments_as_array_flat();
								foreach ($audiences as $key => $label) {
									?>
									<label>
										<input type="checkbox" class="exm_settings_change" name="exm_condition_audiences" value="<?php echo $key; ?>" />
										<?php echo $label; ?>
									</label>
									<?php
								}
								?>
								<br />
								<span class="description">Display popup just for these audiences.</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_condition_audiences_matching_mode">Audience matching mode</label>
							</th>
							<td>
								<select class="exm_settings_change" id="exm_condition_audiences_matching_mode" name="exm_condition_audiences_matching_mode">
									<option value="any">Any</option>
									<option value="all">All</option>
									<option value="none">None</option>
								</select>
								<br />
								<span class="description">User must match all or just a single segment.</span>
							</td>
						</tr>
						<tr>
							<th scope="row">Display only on homepage</th>
							<td>
								<fieldset>
									<label for="exm_condition_homepage">
										<input id="exm_condition_homepage" class="exm_settings_change" value="true" name="exm_condition_homepage" type="checkbox" />
									</label>
								</fieldset>
								<br />
								<span class="description">If enabled, the popup will only be shown on your homepage.</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exm_condition_weekdays">Weekdays</label>
							</th>
							<td>
								<label>
									<button class="button" onclick='exm_content_settings_check_all("[name=exm_condition_weekdays]"); return false;'><?php echo __("Every day", "tma-webtools") ?></button>
								</label>
								<?php
								$weekdays = [
									"1" => __("Monday", "tma-webtools"),
									"2" => __("Tuesday", "tma-webtools"),
									"3" => __("Wednesday", "tma-webtools"),
									"4" => __("Thursday", "tma-webtools"),
									"5" => __("Friday", "tma-webtools"),
									"6" => __("Saturday", "tma-webtools"),
									"7" => __("Sunday", "tma-webtools"),
									
								];
								foreach ($weekdays as $key => $label) {
									?>
									<label>
										<input type="checkbox" class="exm_settings_change" name="exm_condition_weekdays" value="<?php echo $key; ?>" />
										<?php echo $label; ?>
									</label>
									<?php
								}
								?>
								<br />
								<span class="description">Display popup just on these weekdays.</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
	</div>

</div>
