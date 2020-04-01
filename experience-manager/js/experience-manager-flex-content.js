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
webtools.domReady(function (event) {
	document.querySelectorAll("[data-exm-flex-content]").forEach(function ($item) {
		let content_id = $item.dataset.exmFlexContent;
		EXM.AJAX.request("exm_content", function (data) {
			if (!data.error) {
				EXM.DOM.insertElement("style", "text/css", data.css);
				$item.innerHTML = data.html;
				EXM.DOM.insertElement("script", "text/javascript", data.js);
			}
		}, "&id=" + content_id);
	});
});





