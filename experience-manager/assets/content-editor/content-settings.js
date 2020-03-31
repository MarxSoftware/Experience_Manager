let exm_contains_recommendation = (config) => {
	return typeof config.recommendation !== "undefined";
};
let exm_contains_loading = (config) => {
	return typeof config.loading !== "undefined";
};

var exm_content_form = {
	"default_settings": () => {
		return {
			recommendation: {},
			loading: {}
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
		}
	},
	functions: [
		(config) => {
			if (config.recommendation && config.recommendation.enabled) {
				document.querySelector("#exm_recommendation_settings").style.display = "block";
			}
		}
	]
};
jQuery(function () {
	if (window.exmContentSettingsValue) {
		console.log(window.exmContentSettingsValue);
		Object.keys(exm_content_form.fields).forEach((key) => {
			var field = exm_content_form.fields[key];
			if (field.exists_function && !field.exists_function(window.exmContentSettingsValue)) {
				console.log(key + " / not set");
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
	document.querySelector("#exm_recommendation").addEventListener("change", (event) => {
		if (event.target.checked) {
			document.querySelector("#exm_recommendation_settings").style.display = "block";
		} else {
			document.querySelector("#exm_recommendation_settings").style.display = "none";
		}
	});
	document.querySelectorAll(".exm_settings_change").forEach(function ($item) {
		$item.addEventListener("change", (event) => {
			exm_content_settings_update_fields();
		});
	});
});

function exm_content_settings_update_fields() {
//	let settings = {};
//	settings.content_type = document.querySelector("#exm_content_type").value;
//	settings.recommendation = {};
//	settings.recommendation.enabled = document.querySelector("#exm_recommendation").checked;
//	settings.recommendation.type = document.querySelector("#exm_recommendation_type").value;
//	settings.recommendation.count = document.querySelector("#exm_recommendation_count").value;
//	settings.loading = {};
//	settings.loading.animation = document.querySelector("#exm_content_loading_animation").checked;
//	settings.loading.color = document.querySelector("#exm_content_loading_animation_color").value;

	let settings = exm_content_form.default_settings();
	Object.keys(exm_content_form.fields).forEach((key) => {
		var field = exm_content_form.fields[key];
		
		if (field.type === "checkbox") {
			field.set_function(settings, document.querySelector("#" + key).checked);
		} else {
			field.set_function(settings, document.querySelector("#" + key).value);
		}
	});
	console.log(settings);
	document.querySelector("#exm_content_settings").value = JSON.stringify(settings);
}