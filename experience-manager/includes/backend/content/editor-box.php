<div class="exm-content-editor">
	<input type="hidden" name="exm_content_editor_html" id="exm_content_editor_html" />
	<input type="hidden" name="exm_content_editor_js" id="exm_content_editor_js" />
	<input type="hidden" name="exm_content_editor_css" id="exm_content_editor_css"/>
	<div class="tab">
		<button id="defaultOpen" class="tablinks" onclick="selectTab(event, 'London')">Html</button>
		<button class="tablinks" onclick="selectTab(event, 'Paris')">Css</button>
		<button class="tablinks" onclick="selectTab(event, 'Tokyo')">JavaScript</button>
	</div>

	<div id="London" class="tabcontent">
		<div class="editor" id="html-editor"></div>
	</div>

	<div id="Paris" class="tabcontent">
		<div class="editor" id="css-editor"></div>
	</div>

	<div id="Tokyo" class="tabcontent">
		<div class="editor" id="js-editor"></div>
	</div>
	
	<div class="preview-container">
		<iframe class="preview-iframe" id="exm-preview-target"></iframe>
	</div>
</div>