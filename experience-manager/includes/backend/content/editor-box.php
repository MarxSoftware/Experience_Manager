<div class="exm-content-editor">
	<input type="hidden" name="exm_content_editor_html" id="exm_content_editor_html" />
	<input type="hidden" name="exm_content_editor_js" id="exm_content_editor_js" />
	<input type="hidden" name="exm_content_editor_css" id="exm_content_editor_css"/>
	<div class="tab">
		<button id="defaultOpen" class="tablinks" onclick="selectTab(event, 'exm_html_editor')">Html</button>
		<button class="tablinks" onclick="selectTab(event, 'exm_css_editor')">Css</button>
		<button class="tablinks" onclick="selectTab(event, 'exm_javascript_editor')">JavaScript</button>
	</div>

	<div id="exm_html_editor" class="tabcontent">
		<div class="editor" id="html-editor"></div>
	</div>

	<div id="exm_css_editor" class="tabcontent">
		<div class="editor" id="css-editor"></div>
	</div>

	<div id="exm_javascript_editor" class="tabcontent">
		<div class="editor" id="js-editor"></div>
	</div>
</div>