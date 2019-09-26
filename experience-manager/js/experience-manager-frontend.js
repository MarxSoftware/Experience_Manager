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
(function ($) {


	function tma_webtools_update(segments) {
		webtools.Frontend.update(segments.user_segments);
	}

	webtools.domReady(function (event) {
		
		webtools.Request.get(TMA_CONFIG.rest_url + "experience-manager/v1/segments").then(function (response) {
			response.json().then(tma_webtools_update);
		});
	});

})(jQuery);

