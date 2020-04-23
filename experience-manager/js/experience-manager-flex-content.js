/* 
 * Copyright (C) 2016 Thorsten Marx
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

EXM.Dom.ready(function (event) {
	document.querySelectorAll("[data-exm-flex-content]").forEach(function ($item) {
		let content_id = $item.dataset.exmFlexContent;
		let current_id = $item.dataset.exmCurrentId;
		let frontpage = $item.dataset.exmFrontpage;
		EXM.Ajax.request("exm_content", function (data) {
			if (!data.error) {
				EXM.Dom.insertHeadElement("style", "text/css", data.css);
				$item.innerHTML = data.html;
				EXM.Dom.insertHeadElement("script", "text/javascript", data.js);
			}
		}, "&id=" + content_id + "&post_id=" + current_id + "&frontpage=" + frontpage);

		EXM.Ajax.request("exm_content_popups", function (data) {
			if (!data.error && data.popups.length > 0) {
				let popups = data.popups.filter((popup) => {
					const cookie_name = popup.settings.popup.cookie_name ? popup.settings.popup.cookie_name : null;
					if (typeof cookie_name !== "undefined" 
							&& cookie_name !== null 
							&& cookie_name !== "") {
						return EXM.Cookie.get(cookie_name) === null;
					}
					return true;
				});
				if (popups.length > 0) {
					const popup = popups[0];

					// set the cookie
					const cookie_name = popup.settings.popup.cookie_name ? popup.settings.popup.cookie_name : null;
					if (typeof cookie_name !== "undefined" && cookie_name !== null && cookie_name !== "") {
						const cookie_lifetime = popup.settings.popup.cookie_lifetime;
						const cookie_lifetime_unit = popup.settings.popup.cookie_lifetime_unit;

						let life_time = 0;
						if (cookie_lifetime_unit === "day") {
							life_time = (cookie_lifetime * 24 * 60 * 60 * 1000);
						} else if (cookie_lifetime_unit === "week") {
							life_time = (cookie_lifetime * 7 * 24 * 60 * 60 * 1000);
						} else if (cookie_lifetime_unit === "month") {
							life_time = (cookie_lifetime * 30 * 24 * 60 * 60 * 1000);
						}

						EXM.Cookie.set(cookie_name, true, life_time);
					}
					EXM.Popup.init({
						'id': "pop-" + popup.id,
						'animation': popup.settings.popup.animation,
						'position': popup.settings.popup.position,
						'trigger': {type: popup.settings.popup.trigger},
						'content': popup.content
					});
				}
			}
		}, "&post_id=" + current_id + "&frontpage=" + frontpage)
	});
});





