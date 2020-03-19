<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Segment;

/**
 * Description of class
 *
 * @author marx
 */
class SegmentValidator {

	var $definedTypes = [];

	/**
	  [
	  "type_name" : [
	  "feld" : "feld_type"
	  ]]

	 * */
	protected static $_instance = null;

	/**
	 * get instance
	 *
	 * Falls die einzige Instanz noch nicht existiert, erstelle sie
	 * Gebe die einzige Instanz dann zurück
	 *
	 * @return   Singleton
	 */
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	function __construct() {
		$this->defineType("and", [
			"conditions" => "array"
		]);
		$this->defineType("or", [
			"conditions" => "array"
		]);
		$this->defineType("not", [
			"conditions" => "array"
		]);
		$this->defineType("pageview", [
			"page" => "string",
			"type" => "string",
			"count" => "integer"
		]);
		$this->defineType("event", [
			"event" => "string",
			"count" => "integer"
		]);
		$this->defineType("visit", [
			"count" => "integer"
		]);
		$this->defineType("category", [
			"path" => "string",
			"field" => "string",
			"count" => "integer"
		]);
		$this->defineType("ecommerce_coupon", [
			"count" => "integer"
		]);
		$this->defineType("ecommerce_order", [
			"count" => "integer"
		]);
	}

	public function defineType($type, $attributes) {
		$this->definedTypes[$type] = [
			"attributes" => $attributes
		];
	}

	public function validate($jsonString) {
		$jsonobject = json_decode($jsonString);
		if ($jsonobject === NULL) {
			return "Not a valid json string";
		}
		return $this->validate_conditional($jsonobject);
	}

	function validate_conditional($conditional) {
		if (!property_exists($conditional, "conditional")) {
			return "conditional attribute is missing";
		}
		$name = $conditional->conditional;
		if (array_key_exists($name, $this->definedTypes)) {
			$definition = $this->definedTypes[$name];
			foreach ($definition["attributes"] as $key => $value) {
				if (property_exists($conditional, $key)) {
					if (!$this->validate_property($conditional->$key, $value)) {
						return "attribute " . $key . " not of type " . $value;
					}
				}
			}
		}
		if (property_exists($conditional, "conditions")) {
			foreach ($conditional->conditions as $condition) {
				$valid = $this->validate_conditional($condition);
				if ($valid !== TRUE) {
					return $valid;
				}
			}
		}

		return TRUE;
	}

	private function validate_property($property, $type) {
		switch ($type) {
			case "array":
				return $this->isArray($property);
			case "boolean":
				return is_bool($property);
			case "integer":
				return is_integer($property);
			case "double":
				return is_double($property);
			case "string":
				return is_string($property);
			default:
				break;
		}
		return false;
	}

	protected function isNumber($data) {
		return is_integer($data) || is_float($data);
	}

	protected function isArray($data) {
		return is_array($data) && (empty($data) || array_keys($data) === range(0, count($data) - 1));
	}

}
