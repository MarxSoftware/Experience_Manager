<style>

</style>

<script id="exm_content_element_template" type="x-tmpl-mustache">
	{{#elements}}
	<div class="column">
	<div class="ui card">
	<div class="image">
	<img src="{{{image_url}}}" class="content">
	</div>
	<div class="content">
	<a class="header">{{title}}</a>
	<div class="description">
	{{description}}
	</div>
	</div>
	<div class="extra content">
	<button class="ui button" onclick="exm_content_library_element_insert('{{id}}')">Insert</button>
	</div>
	</div>
	</div>
	{{/elements}}
</script>

<div class="ui modal" id="exm_content_library">
	<i class="close icon"></i>
	<div class="header">
		Flex Content Library
	</div>
	<div class="scrolling  content">
		<div class="ui menu">
			<div class="item">
				<div class="field">
					<div class="ui selection dropdown" id="exm_content_type_filter">
						<input type="hidden" name="exm_content_category" value="ALL">
						<i class="dropdown icon"></i>
						<div class="default text">Content type</div>
						<div class="menu">
							<div class="item selected" data-value="ALL">All</div>
							<div class="item" data-value="product_recommendation">Product recommendations</div>
							<div class="item" data-value="banner">Banners</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="ui three column doubling stackable grid container"
			 id="exm_content_element_container">
		</div>
	</div>
</div>