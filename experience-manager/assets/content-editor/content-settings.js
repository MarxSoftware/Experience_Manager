jQuery(function () {
	if (window.exmContentSettingsValue) {
		document.querySelector("#exm_content_type").value = window.exmContentSettingsValue.content_type;

		if (window.exmContentSettingsValue.recommendation) {
			document.querySelector("#exm_recommendation_count").value = window.exmContentSettingsValue.recommendation.count;
			document.querySelector("#exm_recommendation_type").value = window.exmContentSettingsValue.recommendation.type;
			if (window.exmContentSettingsValue.content_type === "recommendation") {
				document.querySelector("#exm_recommendation_settings").style.display = "block";
			}
		}
		if (window.exmContentSettingsValue.loading) {
			document.querySelector("#exm_content_loading_animation").value = window.exmContentSettingsValue.loading.animation;
			document.querySelector("#exm_content_loading_animation_color").value = window.exmContentSettingsValue.loading.color;
		}


		exm_content_settings_update_fields();
	}
	document.querySelector("#exm_content_type").addEventListener("change", ($elem) => {
		if ($elem.target.value === "recommendation") {
			document.querySelector("#exm_recommendation_settings").style.display = "block";
		} else {
			document.querySelector("#exm_recommendation_settings").style.display = "none";
		}
	});
	document.querySelectorAll(".exm_settings_change").forEach(function ($item) {
		$item.addEventListener("change", () => {
			exm_content_settings_update_fields();
		});
	});
});

function exm_content_settings_update_fields() {
	let settings = {};
	settings.content_type = document.querySelector("#exm_content_type").value;
	settings.recommendation = {};
	settings.recommendation.type = document.querySelector("#exm_recommendation_type").value;
	settings.recommendation.count = document.querySelector("#exm_recommendation_count").value;
	settings.loading = {};
	settings.loading.animation = document.querySelector("#exm_content_loading_animation").checked;
	settings.loading.color = document.querySelector("#exm_content_loading_animation_color").value;
	console.log(settings);
	document.querySelector("#exm_content_settings").value = JSON.stringify(settings);
}