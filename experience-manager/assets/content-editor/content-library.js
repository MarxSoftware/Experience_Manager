/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

const FUNCTION_EMPTY = () => {};
const FILTER_ALL = () => true;
const EXM_RESPONSE_JSON = (response) => response.json();
const EXM_RESPONSE_TEXT = (response) => response.text();
EXM.Dom.ready(() => {

	document.querySelector("#tma_content_library").addEventListener("click", (event) => {
		event.preventDefault();

		fetch(TMA_CONFIG.plugin_url + "/assets/content-editor/content-library/index.json?_t=" + new Date().getTime())
				.then(response => response.json())
				.then(contentLibrary => {
					window.EXM_CONTENT_LIBRARY = contentLibrary
					display_content_library(FILTER_ALL, () => {
						jQuery("#exm_content_library")
								.modal(
								{autofocus: false}
								).modal('show');
					});
				});
		jQuery("#exm_content_type_filter").dropdown({
			onChange: function (value, text, $selectedItem) {
				let filterFunction = (element) => {
					if (Array.isArray(element.category)) {
						return element.category.includes(value);
					}
					return element.category === value
				};
				if (value === "ALL") {
					filterFunction = FILTER_ALL;
				}
				display_content_library(
						filterFunction,
						FUNCTION_EMPTY
						);
			}
		});
	});
});


const display_content_library = (filterFunction, callbackFunction) => {
	let templateContent = document.getElementById("exm_content_element_template").innerHTML;
	let data = {
		'elements': window.EXM_CONTENT_LIBRARY.elements.filter(filterFunction)
	};
	var rendered = Mustache.render(templateContent, data);
	document.getElementById('exm_content_element_container').innerHTML = rendered;
	callbackFunction();
}



const exm_content_library_element_insert = (ce_id) => {
	
	let counter = 0;
	const update_preview = () => {
		counter++;
		if (counter === 4) {
			exm_content_editor_update_preview();
		}
	}
	
	exm_content_library_element_load(ce_id + ".html", EXM_RESPONSE_TEXT, (content) => {
		EXM.htmlEditor.setValue(content);
		update_preview();
	});
	exm_content_library_element_load(ce_id + ".css", EXM_RESPONSE_TEXT, (content) => {
		EXM.cssEditor.setValue(content);
		update_preview();
	});
	exm_content_library_element_load(ce_id + ".js", EXM_RESPONSE_TEXT, (content) => {
		EXM.jsEditor.setValue(content);
		update_preview();
	});
	exm_content_library_element_load(ce_id + ".json", EXM_RESPONSE_JSON, (content) => {
		exm_update_form_from_settings(content)
		update_preview();
	});
	jQuery("#exm_content_library").modal('hide');
	
}

const exm_content_library_element_load = (template, responseHandler, updateCallback) => {
	fetch(TMA_CONFIG.plugin_url + "/assets/content-editor/content-library/snippets/" + template)
			.then(responseHandler)
			.then(content => {
				updateCallback(content)
			});
}