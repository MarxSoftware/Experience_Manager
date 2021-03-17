let exm_contains_recommendation = (config) => {
	return typeof config.recommendation !== "undefined";
};
let exm_contains_loading = (config) => {
	return typeof config.loading !== "undefined";
};

var exm_content_formDefinition = {
	"default_settings": () => {
		return {
			recommendation: {},
			loading: {},
		};
	},
	"fields": {
		"exm_content_type": {
			type: "select",
			get_function: (config) => {
				return config.content_type;
			},
			set_function: (config, value) => {
				config.content_type = value;
			}
		},
		"exm_recommendation": {
			type: "checkbox",
			exists_function: exm_contains_recommendation,
			get_function: (config) => {
				return config.recommendation.enabled;
			},
			set_function: (config, value) => {
				config.recommendation.enabled = value;
			}
		},
		"exm_shortcode": {
			type: "checkbox",
			get_function: (config) => {
				return config.shortcode;
			},
			set_function: (config, value) => {
				config.shortcode = value;
			}
		},
		"exm_recommendation_count": {
			type: "number",
			exists_function: exm_contains_recommendation,
			get_function: (config) => {
				return config.recommendation.count;
			},
			set_function: (config, value) => {
				config.recommendation.count = value;
			}
		},
		"exm_recommendation_resolution": {
			type: "select",
			exists_function: exm_contains_recommendation,
			get_function: (config) => {
				return config.recommendation.resolution;
			},
			set_function: (config, value) => {
				config.recommendation.resolution = value;
			}
		},
		"exm_recommendation_type": {
			type: "select",
			exists_function: exm_contains_recommendation,
			get_function: (config) => {
				return config.recommendation.type;
			},
			set_function: (config, value) => {
				config.recommendation.type = value;
			}
		},
		"exm_content_loading_animation": {
			type: "checkbox",
			exists_function: exm_contains_loading,
			get_function: (config) => {
				return config.loading.animation;
			},
			set_function: (config, value) => {
				config.loading.animation = value;
			}
		},
		"exm_content_loading_animation_color": {
			type: "color",
			exists_function: exm_contains_loading,
			get_function: (config) => {
				return config.loading.color;
			},
			set_function: (config, value) => {
				config.loading.color = value;
			}
		},

	},
	functions: [
	]
};

const exm_update_form_from_settings = (settings) => {
	Object.keys(exm_content_formDefinition.fields).forEach((key) => {
		let field = exm_content_formDefinition.fields[key];
		if (field.exists_function && !field.exists_function(settings)) {
			return;
		}
		let value = field.get_function(settings);
		if (typeof value === "undefined") {
			return;
		}
		if (field.type === "checkbox") {
			document.querySelector("#" + key).checked = value;
		} else if (field.type === "multi_checkbox") {
			document.querySelectorAll("[name=" + key + "]").forEach(($element) => {
				let attr_value = $element.getAttribute("value");
				if (value.includes(attr_value)) {
					$element.checked = true;
				}
			});
		} else {
			document.querySelector("#" + key).value = value;
		}
	});
	exm_content_formDefinition.functions.forEach((fn) => {
		fn(settings);
	});

	exm_content_update_formdata_from_form();
};


function exm_content_update_formdata_from_form() {
	let settings = exm_content_formDefinition.default_settings();
	Object.keys(exm_content_formDefinition.fields).forEach((key) => {
		var field = exm_content_formDefinition.fields[key];

		if (field.type === "checkbox") {
			field.set_function(settings, document.querySelector("#" + key).checked);
		} else if (field.type === "multi_checkbox") {
			let values = [];
			document.querySelectorAll("[name='" + key + "']").forEach(($element) => {
				if ($element.checked) {
					values.push($element.getAttribute("value"));
				}
			});
			field.set_function(settings, values);
		} else {
			field.set_function(settings, document.querySelector("#" + key).value);
		}
	});
	document.querySelector("#exm_content_settings").value = JSON.stringify(settings);
	window.exmContentSettingsValue = settings;
}

function exm_content_settings_check_all(selector) {
	document.querySelectorAll(selector).forEach(($element) => {
		$element.checked = true;
	});
	exm_content_update_formdata_from_form();
}

EXM.Dom.ready(function (event) {
	if (window.exmContentSettingsValue) {
		exm_update_form_from_settings(window.exmContentSettingsValue);
	}

	document.querySelectorAll(".exm_settings_change").forEach(function ($item) {
		$item.addEventListener("change", (event) => {
			exm_content_update_formdata_from_form();
		});
	});
});