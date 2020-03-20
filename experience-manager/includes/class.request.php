<?php

/*
 * Copyright (C) 2016 thmarx
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

/**
 * Description of TMA_Request
 *
 * @author thmarx
 */
class TMA_Request {

	private $options;

	public function __construct() {
		$this->options = get_option('tma_webtools_option');
	}

	public static function getUserID() {
		return \TMA\ExperienceManager\TMA_COOKIE_HELPER::getInstance()->getCookie(TMA_COOKIE_HELPER::$COOKIE_USER, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE);
	}

	private function garded($function_to_gard) {
		try {
			return $function_to_gard();
		} catch (Exception $ex) {
			tma_exm_log($ex->getMessage());
			return FALSE;
		}
	}

	/**
	 * setup the request object and return
	 */
	public function get($url, $parameters = [], $headers = ['Content-Type' => 'text/plain', 'Accept' => 'application/json']) {

		if (!isset($this->options["webtools_apikey"]) || !isset($this->options['webtools_url'])) {
			return FALSE;
		}

		tma_exm_log("get request: " . $url);

		$webtools_url = $this->get_webtools_url() . $this->clean_url($url);
//		$headers["apikey"] = $this->options["webtools_apikey"];

		$parameters['method'] = "GET";
		$parameters['timeout'] = "45";
		$parameters['headers'] = $headers;
//		$parameters['headers']['Content-Type'] = "application/json";
//		$parameters['headers']['Content-Type'] = "text/plain";
		$parameters['headers']['apikey'] = $this->options["webtools_apikey"];
		$parameters['headers']['site'] = tma_exm_get_site();

		tma_exm_log(json_encode($parameters));

		$cache_key = $webtools_url . "_" . json_encode($parameters);
		$result = wp_cache_get($cache_key);
		if (false === $result) {
			$result = $this->garded(function () use ($webtools_url, $parameters) {
				$response = wp_remote_get($webtools_url, $parameters);
				if (is_array($response) && !is_wp_error($response)) {
					return $response; // use the content
				}
				return FALSE;
			});

			wp_cache_set($cache_key, $result);
		}

		return $result;
	}

	public function delete($url) {

		if (!isset($this->options["webtools_apikey"]) || !isset($this->options['webtools_url'])) {
			return FALSE;
		}

		$webtools_url = $this->get_webtools_url() . $this->clean_url($url);

		$parameters = array();
		$parameters['method'] = "DELETE";
		//$parameters['body'] = json_encode($data);
		$parameters['timeout'] = "45";
		$parameters['headers'] = array();
		$parameters['headers']['Content-Type'] = "application/json";
		$parameters['headers']['apikey'] = $this->options["webtools_apikey"];
		$parameters['headers']['site'] = tma_exm_get_site();

		return $this->garded(function () use ($webtools_url, $parameters) {
					$response = wp_remote_request($webtools_url, $parameters);
					if (is_array($response) && !is_wp_error($response)) {
						return $response; // use the content
					}
					return FALSE;
				});
	}

	public function post($url, $data = NULL) {

		if (!isset($this->options["webtools_apikey"]) || !isset($this->options['webtools_url'])) {
			return FALSE;
		}
		$webtools_url = $this->get_webtools_url() . $this->clean_url($url);

		$parameters = array();
		$parameters['method'] = "POST";
		$parameters['body'] = json_encode($data);
		$parameters['timeout'] = "45";
		$parameters['headers'] = array();
		$parameters['headers']['Content-Type'] = "application/json";
		$parameters['headers']['Accept'] = "application/json";
		$parameters['headers']['apikey'] = $this->options["webtools_apikey"];
		$parameters['headers']['site'] = tma_exm_get_site();

		return $this->garded(function () use ($webtools_url, $parameters) {
					$response = wp_remote_post($webtools_url, $parameters);
					if (is_array($response) && !is_wp_error($response)) {
						return $response; // use the content
					}
					return FALSE;
				});
	}

	public function put($url, $data = NULL) {

		if (!isset($this->options["webtools_apikey"]) || !isset($this->options['webtools_url'])) {
			return FALSE;
		}
		$webtools_url = $this->get_webtools_url() . $this->clean_url($url);

		$parameters = array();
		$parameters['method'] = "PUT";
		$parameters['body'] = json_encode($data);
		$parameters['timeout'] = "45";
		$parameters['headers'] = array();
		$parameters['headers']['Content-Type'] = "application/json";
		$parameters['headers']['Accept'] = "application/json";
		$parameters['headers']['apikey'] = $this->options["webtools_apikey"];
		$parameters['headers']['site'] = tma_exm_get_site();

		return $this->garded(function () use ($webtools_url, $parameters) {
					tma_exm_log("url " . $webtools_url);
					tma_exm_log("parameters " . json_encode($parameters));
					$response = wp_remote_request($webtools_url, $parameters);
					tma_exm_log("response " . json_encode($response));
					if (is_array($response) && !is_wp_error($response)) {
						return $response; // use the content
					}
					return FALSE;
				});
	}

	private function clean_webtools_url($url) {
		if (!tma_endsWith($url, "/")) {
			return $url . "/";
		}
		return $url;
	}

	private function clean_url($url) {
		if (tma_startsWith($url, "/")) {
			return ltrim($url, "/");
		}
		return $url;
	}

	public function module($module, $path, $parameters) {
		$module_url = "/rest/module/$module$path";
		$module_url .= "?" . http_build_query($parameters);

		$response = $this->get($module_url);
		tma_exm_log(json_encode($response));
		if ((is_object($response) || is_array($response)) && !is_wp_error($response)) {
			$result = $response['body']; // use the content
			return json_decode($result);
		}

		return FALSE;
	}

	/**
	 * checks if the platform modules are installed
	 * 
	 * <platform_url>/rest/module/installed
	 * 
	 * {
	  "error": false,
	  "modules": [
	  {
	  "name": "Core Module Entities",
	  "active": true,
	  "id": "core-module-entities",
	  "version": "1.3.0"
	  },...
	  ]}
	 */
	public function check_installed_modules($dependencies = []) {
		if (!is_array($dependencies) || sizeof($dependencies) === 0) {
			return TRUE;
		}
		$module_url = "/rest/module/installed";

		$response = $this->get($module_url, NULL, ['Content-Type' => 'text/plain', 'Accept' => 'application/json']);
		tma_exm_log(json_encode($response));
		if ((is_object($response) || is_array($response)) && !is_wp_error($response)) {
			$result = $response['body']; // use the content
			$installed_modules = json_decode($result);
			if (property_exists($installed_modules, "modules") && is_array($installed_modules->modules)) {
				foreach ($dependencies AS $module) {
					$found = array_filter($installed_modules->modules, function($installedModule) use ($module) {
						return $installedModule->id == $module;
					});
					if (!$found) {
						return FALSE;
					}
				}
				return TRUE;
			}
		}

		return FALSE;
	}

	private function get_webtools_url() {
		$url = $this->options['webtools_url'];
		if (!tma_endsWith($url, "/")) {
			return $url . "/";
		}
		return $url;
	}

	public function track($event, $page, $customAttributes = null) {
		if (!isset($this->options["webtools_apikey"]) || !isset($this->options['webtools_url'])) {
			return;
		}

		$uid = \TMA\ExperienceManager\TMA_COOKIE_HELPER::getInstance()->getCookie(TMA_COOKIE_HELPER::$COOKIE_USER, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE);
//		$rid = \TMA\ExperienceManager\TMA_COOKIE_HELPER::getInstance()->getCookie(TMA_COOKIE_HELPER::$COOKIE_REQUEST, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_REQUEST_EXPIRE);
		$rid = $_REQUEST[\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_REQUEST];
		$vid = \TMA\ExperienceManager\TMA_COOKIE_HELPER::getInstance()->getCookie(TMA_COOKIE_HELPER::$COOKIE_VISIT, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_VISIT_EXPIRE);
		$apikey = $this->options["webtools_apikey"];
		$siteid = tma_exm_get_site();

		// http://localhost:8082/rest/track?
		//	event=pageview&site=demosite&page=testpage&fp=6e289159b1106008e0379c9565a44f03&uid=3694ff4e-668b-4484-8ddf-52662bbcc44c&
		//	reqid=a42be86b-2930-4f72-b499-f3dcab983633&vid=8251e717-afea-43bc-b270-1033f482359f&_t=1454323264835&apikey=apikey

		$url .= 'tracking/pixel?event=' . $event;
		$url .= '&site=' . $siteid . '&page=' . urlencode($page);
		$url .= "&uid=" . $uid . '&reqid=' . $rid . '&vid=' . $vid;
		//$url .= "&apikey=" . $apikey;
		// add the custom parameters
		if (isset($customAttributes)) {
			tma_exm_log(json_encode($customAttributes));
			foreach ($customAttributes as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $vk) {
						$url .= '&c_' . urldecode($key) . '=' . urlencode($vk);
					}
				} else {
					$url .= '&c_' . urldecode($key) . '=' . urlencode($value);
				}
			}
		}

		tma_exm_log($url);

		$this->loadContent($url, "{}");
	}

	/**
	 * REST call for the user segments.
	 * 
	 * @param type $userid
	 * @return type
	 */
	public function getSegments($userid) {
		if (!isset($this->options["webtools_apikey"]) || !isset($this->options['webtools_url'])) {
			$result = '{"user" : {"segments" : []}}';
			return json_decode($result);
		}
		$result = wp_cache_get($userid);
		$apikey = $this->options["webtools_apikey"];
		$site = tma_exm_get_site();
		if (false === $result) {
			$url = 'rest/userinformation/user?apikey=' . $apikey . '&user=' . $userid
					. '&site=' . $site;
			tma_exm_log("url: " . $url);
			$result = $this->loadContent($url, '{"user" : {"segments" : []}, "status" : "ok", "default": true}');

			wp_cache_set($userid, $result, "", 60);
		}

		$result = apply_filters("experience-manager/request/userinformation", $result);

		return $result;
	}


	private function loadContent($url, $defaultContent) {
		$result = $defaultContent;

		$parameters = array();
		$parameters['method'] = "GET";
		$parameters['timeout'] = "45";
		$parameters['headers'] = array();
		$parameters['headers']['Content-Type'] = "text/plain";

//		$response = wp_remote_get($url, $parameters);
		$response = $this->get($url, [], ['Content-Type' => "text/plain"]);
		tma_exm_log(json_encode($response));
		if ($response !== FALSE && (is_object($response) || is_array($response)) && !is_wp_error($response)) {
			$result = $response['body']; // use the content
		}

		return json_decode($result);
	}

	private function postContent($url, $body, $defaultContent) {
		$result = $defaultContent;

		$parameters = array();
		$parameters['body'] = $body;
		$parameters['method'] = "POST";
		$parameters['timeout'] = "45";
		$parameters['headers'] = array();
		$parameters['headers']['Content-Type'] = "text/plain";


		$response = wp_remote_post($url, $parameters);
		if (is_array($response) && !is_wp_error($response)) {
			$result = $response['body']; // use the content
		}

		return json_decode($result);
	}

}
