/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


EXM.Dom.ready(() => {

	document.querySelector("#tma_content_library").addEventListener("click", (event) => {
		event.preventDefault();

		fetch(TMA_CONFIG.plugin_url + "/assets/content-editor/content-library/index.json")
				.then(response => response.json())
				.then(contentLibrary => {
					let templateContent = document.getElementById("exm_content_element_template").innerHTML;
					var rendered = Mustache.render(templateContent, contentLibrary);
					document.getElementById('exm_content_element_container').innerHTML = rendered;

					jQuery("#exm_content_library").modal('show');
				});
	});
});

function exm_content_library_element_insert(ce_id) {
	exm_content_library_element_update_editor(ce_id + ".html", (content) => {
		EXM.htmlEditor.setValue(content);
	});
	exm_content_library_element_update_editor(ce_id + ".css", (content) => {
		EXM.cssEditor.setValue(content);
	});
	exm_content_library_element_update_editor(ce_id + ".js", (content) => {
		EXM.jsEditor.setValue(content);
	});

	fetch(TMA_CONFIG.plugin_url + "/assets/content-editor/content-library/snippets/" + ce_id + ".json")
			.then(response => response.json())
			.then(settings => {
				exm_update_form_from_settings(settings)
			});

	jQuery("#exm_content_library").modal('hide');
}

function exm_content_library_element_update_editor(template, updateCallback) {
	fetch(TMA_CONFIG.plugin_url + "/assets/content-editor/content-library/snippets/" + template)
			.then(response => response.text())
			.then(content => {
				updateCallback(content)
			});
}