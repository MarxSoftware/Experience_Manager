<?php

/*
 * Copyright (C) 2017 marx
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

namespace TMA\ExperienceManager;

class Gutenberg_Integration {

	/**
	 * Start up
	 */
	public function __construct() {

		add_action('enqueue_block_editor_assets', array($this, 'register_block_assets'));
	}

	/**
	 * Registers scripts
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_block_assets() {
		$block_js = 'assets/gutenberg/index.js';
		// Script
		wp_register_script(
				'targeting-block-js',
				TMA_EXPERIENCE_MANAGER_URL . $block_js,
				array(
					'lodash', 'wp-components', 'wp-compose', 'wp-editor', 'wp-element', 'wp-hooks', 'wp-i18n', 'wp-polyfill'
				),
				filemtime(TMA_EXPERIENCE_MANAGER_DIR . $block_js)
		);
		wp_enqueue_script('targeting-block-js');
	}

}