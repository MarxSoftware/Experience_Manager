<h3>Default settings</h3>
<p>This is the first set of form data</p>
<table class="form-table">
    <tbody>
        <tr>
			<th scope="row">
				<label for="exm_content_type">Content type</label>
			</th>
			<td>
				<select class="exm_settings_change" id="exm_content_type" name="exm_content_type">
					<option value="simple_content">Simple Content</option>
					<option value="recommendation">Recommendation</option>
				</select>
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

<div id="exm_recommendation_settings" style="display: none;">
	<h3>Recommendation settings</h3>
	<p>These are settings related to content type recommendation</p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="exm_recommendation_type">Recommendation type</label>
				</th>
				<td>
					<select class="exm_settings_change" id="exm_recommendation_type" name="exm_content_type">
						<option value="recently_viewed">Recently viewed</option>
						<option value="frequently_purchased">Frequently purchased</option>
						<option value="popular">Popular products</option>
						<option value="similar_products">Similar products</option>
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
<input type="hidden" name="exm_content_settings" id="exm_content_settings" />
