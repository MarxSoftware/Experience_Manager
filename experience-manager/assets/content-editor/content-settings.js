let exm_contains_recommendation = (config) => {
	return typeof config.recommendation !== "undefined";
};
let exm_contains_loading = (config) => {
	return typeof config.loading !== "undefined";
};
let exm_contains_popup = (config) => {
	return typeof config.popup !== "undefined";
};
let exm_contains_conditions = (config) => {
	return typeof config.conditions !== "undefined";
};

var exm_content_form = {
	"default_settings": () => {
		return {
			recommendation: {},
			loading: {},
			popup: {},
			conditions: {
				post_types: [],
				audiences: [],
				weekdays: [],
				roles: []
			}
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
		},
		"exm_popup_cookie_name": {
			type: "text",
			exists_function: exm_contains_popup,
			get_function: (config) => {
				return config.popup.cookie_name;
			},
			set_function: (config, value) => {
				config.popup.cookie_name = value;
			}
		},
		"exm_popup_cookie_lifetime": {
			type: "number",
			exists_function: exm_contains_popup,
			get_function: (config) => {
				return config.popup.cookie_lifetime;
			},
			set_function: (config, value) => {
				config.popup.cookie_lifetime = value;
			}
		},
		"exm_popup_cookie_lifetime_unit": {
			type: "select",
			exists_function: exm_contains_popup,
			get_function: (config) => {
				return config.popup.cookie_lifetime_unit;
			},
			set_function: (config, value) => {
				config.popup.cookie_lifetime_unit = value;
			}
		},
		"exm_condition_post_type": {
			type: "multi_checkbox",
			exists_function: exm_contains_conditions,
			get_function: (config) => {
				return config.conditions.post_types;
			},
			set_function: (config, value) => {
				config.conditions.post_types = value;
			}
		},
		"exm_condition_audiences": {
			type: "multi_checkbox",
			exists_function: exm_contains_conditions,
			get_function: (config) => {
				return config.conditions.audiences;
			},
			set_function: (config, value) => {
				config.conditions.audiences = value;
			}
		},
		"exm_condition_audiences_matching_mode": {
			type: "select",
			exists_function: exm_contains_popup,
			get_function: (config) => {
				return config.conditions.audiences_matching_mode;
			},
			set_function: (config, value) => {
				config.conditions.audiences_matching_mode = value;
			}
		},
		"exm_condition_weekdays": {
			type: "multi_checkbox",
			exists_function: exm_contains_conditions,
			get_function: (config) => {
				return config.conditions.weekdays;
			},
			set_function: (config, value) => {
				config.conditions.weekdays = value;
			}
		},
		"exm_condition_homepage": {
			type: "checkbox",
			exists_function: exm_contains_conditions,
			get_function: (config) => {
				return config.conditions.homepage;
			},
			set_function: (config, value) => {
				config.conditions.homepage = value;
			}
		},
		"exm_condition_logged_in": {
			type: "checkbox",
			exists_function: exm_contains_conditions,
			get_function: (config) => {
				return config.conditions.logged_in;
			},
			set_function: (config, value) => {
				config.conditions.logged_in = value;
			}
		},
		"exm_condition_roles": {
			type: "multi_checkbox",
			exists_function: exm_contains_conditions,
			get_function: (config) => {
				return config.conditions.roles;
			},
			set_function: (config, value) => {
				config.conditions.roles = value;
			}
		},
	},
	functions: [
		(config) => {
			$cookie_name = document.getElementById("exm_popup_cookie_name");
			value = $cookie_name.value;
			if (value === null || value === "") {
				$cookie_name.value = "exm_popup-" + EXMCONFIG.post_id;
			}

			$cookie_lifetime = document.getElementById("exm_popup_cookie_lifetime");
			value = $cookie_lifetime.value;
			if (value === null || value === "") {
				$cookie_lifetime.value = '30';
				document.getElementById("exm_popup_cookie_lifetime_unit").value = "day";

			}

		}
	]
};
const exm_update_settings_form = (settings) => {
	Object.keys(exm_content_form.fields).forEach((key) => {
		let field = exm_content_form.fields[key];
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
	exm_content_form.functions.forEach((fn) => {
		fn(settings);
	});

	exm_content_settings_update_fields();
};
EXM.Dom.ready(function (event) {
	if (window.exmContentSettingsValue) {
		exm_update_settings_form(window.exmContentSettingsValue);
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
	exm_content_settings_update_fields();
}