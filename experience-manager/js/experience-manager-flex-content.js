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
		console.log(content_id);
		console.log(current_id);
		EXM.Ajax.request("exm_content", function (data) {
			if (!data.error) {
				EXM.Dom.insertHeadElement("style", "text/css", data.css);
				$item.innerHTML = data.html;
				EXM.Dom.insertHeadElement("script", "text/javascript", data.js);
			}
		}, "&id=" + content_id + "&post_id=" + current_id);

		EXM.Ajax.request("exm_content_popups", function (data) {
			console.log(data);
			if (!data.error && data.popups.length > 0) {
				EXM.Popup.init({
					'id': "pop-" + data.popups[0].id,
					'animation': data.popups[0].settings.popup.animation,
					'position': data.popups[0].settings.popup.position,
					'trigger': {type: data.popups[0].settings.popup.trigger},
					'content': data.popups[0].content
				});
			}
		}, "&post_id=" + current_id + "&frontpage=" + frontpage)
	});
});





