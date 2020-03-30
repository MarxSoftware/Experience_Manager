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
function exm_get_ajax_response(ajax_action, callback, parameters) {
	fetch(EXM.ajax_url, {
		method: "POST",
		mode: "cors",
		cache: "no-cache",
		credentials: "same-origin",
		body: "action=" + ajax_action + (typeof parameters !== "undefined" ? parameters : ""),
		headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'}),
	})
			.then((resp) => resp.json())
			.then(function (data) {
				callback(data);
			}).catch(function (error) {
		console.log(JSON.stringify(error));
	});
}

function exm_insert_element(name, type, content) {
	var headElement = document.createElement(name);
	headElement.type = type;
	headElement.innerText = content;
	document.head.appendChild(headElement);
}

if (typeof window.EXM == "undefined") {
	window.EXM = {};
}

document.addEventListener('exm_loaded', function (e) {
	console.log(EXM.User.logged_in);
}, false);

exm_get_ajax_response("exm_user", (data) => {
	window.EXM.User = data;
	document.dispatchEvent(new Event("exm_loaded"));
});

webtools.domReady(function (event) {
	document.querySelectorAll("[data-exm-flex-content]").forEach(function ($item) {
		let content_id = $item.dataset.exmFlexContent;
		exm_get_ajax_response("exm_content", function (data) {
			if (!data.error) {
				exm_insert_element("style", "text/css", data.css);
				$item.innerHTML = data.html;
				exm_insert_element("script", "text/javascript", data.js);
			}
		}, "&id=" + content_id);
	});
});





