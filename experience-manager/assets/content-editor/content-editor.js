const exm_content_editor_update_preview = () => {
	var view = {
		user: {
			logged_in: true
		}
	};

	if (window.exmContentSettingsValue && window.exmContentSettingsValue.recommendation && window.exmContentSettingsValue.recommendation.enabled) {
		EXM.Ajax.request("exm_random_products", function (data) {
			view.recommendation = data;
			exm_content_update_preview_with_view(view);
		}, "&count=" + window.exmContentSettingsValue.recommendation.count);
	} else {
		exm_content_update_preview_with_view(view);
	}
}

const exm_content_update_preview_with_view = (view) => {
	var output_css = Mustache.render(EXM.cssEditor.getValue(), view);
	var output_html = Mustache.render(EXM.htmlEditor.getValue(), view);
	var output_js = Mustache.render(EXM.jsEditor.getValue(), view);


	// html content to write in preview-iframe
	var iframeContent = '<!DOCTYPE html>\n<html lang="en">\n\t<head>\n\t<meta charset="UTF-8">\n\t\n\
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">\n\t<meta http-equiv="X-UA-Compatible" content="ie=edge">' +
			'\n\t\t<style>' + '\n\t\t\t' + output_css + '\n\t\t</style>' + '\n\t</head>\n\t<body>' + '\n\t' + output_html + '\n\t<script>' + '\n\t\t\t' + output_js + '\n\t<\/script>\n\t</body>\n</html>';
	// get document object from window object generated by the preview-iframe
	var target = jQuery('#exm-preview-target')[0].contentWindow.document;
	// opens the document stream for writing
	target.open();
	// writes text in the document
	target.write(iframeContent);
	// closes the document stream for writing
	target.close();
}

const exm_content_editor_update_fields = () => {
	document.querySelector("#exm_content_editor_css").value = EXM.cssEditor.getValue();
	document.querySelector("#exm_content_editor_js").value = EXM.jsEditor.getValue();
	document.querySelector("#exm_content_editor_html").value = EXM.htmlEditor.getValue();
}

jQuery(function () {
	EXM.htmlEditor = ace.edit("html-editor");
	EXM.htmlEditor.session.setMode("ace/mode/html");
	EXM.htmlEditor.session.setTabSize(4);
	EXM.htmlEditor.setValue(window.exmContentEditorValue.html);

	EXM.cssEditor = ace.edit("css-editor");
	EXM.cssEditor.session.setMode("ace/mode/css");
	EXM.cssEditor.session.setTabSize(4);
	EXM.cssEditor.setValue(window.exmContentEditorValue.css);

	EXM.jsEditor = ace.edit("js-editor");
	EXM.jsEditor.session.setMode("ace/mode/javascript");
	EXM.jsEditor.session.setTabSize(4);
	EXM.jsEditor.setValue(window.exmContentEditorValue.js);

	exm_content_editor_update_preview();
	exm_content_editor_update_fields();

	jQuery('.exm-content-editor .editor').on('keyup', function () {
		exm_content_editor_update_fields();
		exm_content_editor_update_preview();
	});

	document.querySelectorAll(".preview-container .devices button").forEach(($button) => {
		$button.addEventListener("click", (event) => {
			event.preventDefault();
			document.querySelectorAll(".preview-container .devices button").forEach(($item) => {
				$item.classList.remove("selected");
			});
			$target = event.target;
			if ($target.tagName === "P") {
				$target = $target.parentElement;
			}
			$target.classList.add("selected");

			let device = $target.dataset.exmDevice;
			document.querySelector(".exm-content-editor #exm-preview-wrapper").classList.remove("tablet");
			document.querySelector(".exm-content-editor #exm-preview-wrapper").classList.remove("laptop");
			document.querySelector(".exm-content-editor #exm-preview-wrapper").classList.remove("smartphone");
			document.querySelector(".exm-content-editor #exm-preview-wrapper").classList.add(device);
		});
	});
	document.querySelectorAll(".exm-content-editor .size-select").forEach(($button) => {
		$button.addEventListener("change", (event) => {
			event.preventDefault();

			let device = event.target.value;
			document.getElementById("exm-preview-target").classList.remove("tablet");
			document.getElementById("exm-preview-target").classList.remove("desktop");
			document.getElementById("exm-preview-target").classList.remove("smartphone");
			document.getElementById("exm-preview-target").classList.add(device);
		});
	});
});