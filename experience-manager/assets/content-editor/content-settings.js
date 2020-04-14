let exm_contains_recommendation = (config) => {
	return typeof config.recommendation !== "undefined";
};
let exm_contains_loading = (config) => {
	return typeof config.loading !== "undefined";
};
let exm_contains_popup = (config) => {
	return typeof config.popup !== "undefined";
};

var exm_content_form = {
	"default_settings": () => {
		return {
			recommendation: {},
			loading: {},
			popup: {}
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
		"exm_recommendation_type": {
			type: "text",
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
		"exm_popup_animation": {
			type: "select",
			exists_function: exm_contains_popup,
			get_function: (config) => {
				return config.popup.animation;
			},
			set_function: (config, value) => {
				config.popup.animation = value;
			}
		},
		"exm_popup_position": {
			type: "select",
			exists_function: exm_contains_popup,
			get_function: (config) => {
				return config.popup.position;
			},
			set_function: (config, value) => {
				config.popup.position = value;
			}
		},
		"exm_popup_trigger": {
			type: "select",
			exists_function: exm_contains_popup,
			get_function: (config) => {
				return config.popup.trigger;
			},
			set_function: (config, value) => {
				config.popup.trigger = value;
			}
		}
	},
	functions: [
	]
};
jQuery(function () {
	if (window.exmContentSettingsValue) {
		Object.keys(exm_content_form.fields).forEach((key) => {
			var field = exm_content_form.fields[key];
			if (field.exists_function && !field.exists_function(window.exmContentSettingsValue)) {
				return;
			}
			var value = field.get_function(window.exmContentSettingsValue);
			if (field.type === "checkbox") {
				document.querySelector("#" + key).checked = value;
			} else {
				document.querySelector("#" + key).value = value;
			}
		});
		exm_content_form.functions.forEach((fn) => {
			fn(window.exmContentSettingsValue);
		});

		exm_content_settings_update_fields();
	}

	document.querySelectorAll(".exm_settings_change").forEach(function ($item) {
		$item.addEventListener("change", (event) => {
			exm_content_settings_update_fields();
		});
	});
});

function exm_content_settings_update_fields() {
	let settings = exm_content_form.default_settings();
	Object.keys(exm_content_form.fields).forEach((key) => {
		var field = exm_content_form.fields[key];
		
		if (field.type === "checkbox") {
			field.set_function(settings, document.querySelector("#" + key).checked);
		} else {
			field.set_function(settings, document.querySelector("#" + key).value);
		}
	});
	document.querySelector("#exm_content_settings").value = JSON.stringify(settings);
	window.exmContentSettingsValue = settings;
	
	console.log(settings);
}