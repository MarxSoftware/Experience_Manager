<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager;

/**
 * Description of tma_cookie_helper
 *
 * @author thmarx
 */
class TMA_COOKIE_HELPER {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public static $MINUTE = 60;
	public static $HOUR;
	public static $DAY;
	public static $YEAR;
	public static $COOKIE_REQUEST = "_tma_rid";
	public static $COOKIE_REQUEST_EXPIRE;
	public static $COOKIE_VISIT = "_tma_vid";
	public static $COOKIE_VISIT_EXPIRE;
	public static $COOKIE_USER = "_tma_uid";
	public static $COOKIE_USER_EXPIRE;

	protected function __construct() {
		
	}

	public function getCookie($name, $value, $expire, $setNew = false) {
		if (isset($_COOKIE[$name])) {
			$value = $_COOKIE[$name];
		}
		if ($setNew) {

			$cookieDomain = null;
			if (isset(get_option('tma_webtools_option')['webtools_cookiedomain'])) {
				$cookieDomain = get_option('tma_webtools_option')['webtools_cookiedomain'];

				$query = ".";
				if (substr($cookieDomain, 0, strlen($query)) !== $query) {
					$cookieDomain = "." . $cookieDomain;
				}
			}
			if (PHP_VERSION_ID < 70300) {
				setcookie($name, $value, time() + $expire, '/; samesite=strict', $cookieDomain, false, false);
			} else {
				setcookie($name, $value, [
					'expires' => time() + $expire,
					'path' => '/',
					'secure' => true,
					'domain' => $cookieDomain,
					'samesite' => 'Strict',
				]);
			}
		}

		return $value;
	}

}

TMA_COOKIE_HELPER::$HOUR = 60 * TMA_COOKIE_HELPER::$MINUTE;
TMA_COOKIE_HELPER::$DAY = 24 * TMA_COOKIE_HELPER::$HOUR;
TMA_COOKIE_HELPER::$YEAR = 365 * TMA_COOKIE_HELPER::$DAY;
TMA_COOKIE_HELPER::$COOKIE_REQUEST_EXPIRE = 3 * TMA_COOKIE_HELPER::$MINUTE;
TMA_COOKIE_HELPER::$COOKIE_VISIT_EXPIRE = 1 * TMA_COOKIE_HELPER::$HOUR;
TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE = 1 + TMA_COOKIE_HELPER::$YEAR;

class UUID {

	public static function v3($namespace, $name) {
		if (!self::is_valid($namespace))
			return false;

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-', '{', '}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for ($i = 0; $i < strlen($nhex); $i += 2) {
			$nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
		}

		// Calculate hash value
		$hash = md5($nstr . $name);

		return sprintf('%08s-%04s-%04x-%04x-%12s',
				// 32 bits for "time_low"
				substr($hash, 0, 8),
				// 16 bits for "time_mid"
				substr($hash, 8, 4),
				// 16 bits for "time_hi_and_version",
				// four most significant bits holds version number 3
				(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,
				// 16 bits, 8 bits for "clk_seq_hi_res",
				// 8 bits for "clk_seq_low",
				// two most significant bits holds zero and one for variant DCE1.1
				(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
				// 48 bits for "node"
				substr($hash, 20, 12)
		);
	}

	public static function v4() {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				// 32 bits for "time_low"
				mt_rand(0, 0xffff), mt_rand(0, 0xffff),
				// 16 bits for "time_mid"
				mt_rand(0, 0xffff),
				// 16 bits for "time_hi_and_version",
				// four most significant bits holds version number 4
				mt_rand(0, 0x0fff) | 0x4000,
				// 16 bits, 8 bits for "clk_seq_hi_res",
				// 8 bits for "clk_seq_low",
				// two most significant bits holds zero and one for variant DCE1.1
				mt_rand(0, 0x3fff) | 0x8000,
				// 48 bits for "node"
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

	public static function v5($namespace, $name) {
		if (!self::is_valid($namespace))
			return false;

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-', '{', '}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for ($i = 0; $i < strlen($nhex); $i += 2) {
			$nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
		}

		// Calculate hash value
		$hash = sha1($nstr . $name);

		return sprintf('%08s-%04s-%04x-%04x-%12s',
				// 32 bits for "time_low"
				substr($hash, 0, 8),
				// 16 bits for "time_mid"
				substr($hash, 8, 4),
				// 16 bits for "time_hi_and_version",
				// four most significant bits holds version number 5
				(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
				// 16 bits, 8 bits for "clk_seq_hi_res",
				// 8 bits for "clk_seq_low",
				// two most significant bits holds zero and one for variant DCE1.1
				(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
				// 48 bits for "node"
				substr($hash, 20, 12)
		);
	}

	public static function is_valid($uuid) {
		return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?' .
						'[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
	}

}
