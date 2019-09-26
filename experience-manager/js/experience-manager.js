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
	var selectedSegments = document.querySelectorAll("[data-tma-group]");
	if (selectedSegments.length > 0) {
		// change icon
		document.getElementById("wp-admin-bar-webtools-adminbar").classList.add("variants_on");
	}

	selectedSegments.forEach(function ($item) {
		var segments = $item.getAttribute("data-tma-segments");
		var segmentArray = segments.split(",");
		var found = TMA_CONFIG.segments.filter(function (element) {
			return segmentArray.includes(""+element.id);
		});
		$item.setAttribute("data-tma-segment-names", found.map(i => i.name).join(","));
	});
});

function tma_segment_selector(clickedElement) {
	clickedElement.classList.toggle('tma-selected');
	webtools.Frontend.update(tma_selected_elements());
}

function tma_show_variants ($clickedElement) {
	if ($clickedElement.classList.contains('tma-selected')) {
		$clickedElement.classList.remove('tma-selected');
		webtools.Frontend.update([]);
	} else {
		$clickedElement.classList.add('tma-selected');
		document.querySelectorAll(".tma-hide").forEach (function ($item) {
			$item.classList.remove("tma-hide");
		});
	}
}
function tma_segment_clear() {
	webtools.Frontend.update([]);
	var selectedSegments = document.querySelectorAll(".tma-selected");
	selectedSegments.forEach(function ($e)  {
		$e.classList.remove('tma-selected');
	});
}
function tma_selected_elements() {
	var selectedSegmentsArray = [];
	var selectedSegments = document.querySelectorAll(".tma-selected");
	for (var i = 0; i < selectedSegments.length; i++) {
		selectedSegmentsArray.push(selectedSegments[i].parentNode.getAttribute("id").substr(13));
	}
	return selectedSegmentsArray;
}

function tma_highlight($clickedElement) {
	if ($clickedElement.classList.contains('tma-selected')) {
		$clickedElement.classList.remove('tma-selected');
		webtools.Highlight.deactivate();
	} else {
		$clickedElement.classList.add('tma-selected');
		webtools.Highlight.activate(Array.apply([], document.querySelectorAll('[data-tma-group]')));
	}
}