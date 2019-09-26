<?php

namespace TMA\ExperienceManager\Segment;

class Translator {

	private $the_site;

	public function __construct($site = "") {
		$this->the_site = $site;
	}

	public function translate($json_definition = "{}"): string {
		
		tma_exm_log("translate: " . $json_definition);
		
		$definition = json_decode($json_definition);

		$segment = "segment()";

		$segment .= $this->handleBrowsers($definition);
		$segment .= $this->handleDevices($definition);
		$segment .= $this->handleEvent($definition);
		$segment .= $this->handleOperationSystems($definition);
		$segment .= $this->handleVisit($definition);
		$segment .= $this->handleCategories($definition, "wp_categories", "category");
		$segment .= $this->handleCategories($definition, "wc_categories", "product_cat");

		$segment .= ";";

		return $segment;
	}

	//categories

	public function handleCategories($data, $key, $taxonomy) {

		$categories = [];
		if (property_exists($data, $key) && property_exists($data->$key, "categories")) {
			foreach ($data->$key->categories AS $category) {
				$categories[] = "/" . get_term_parents_list($category, $taxonomy, ["format" => "slug", "link" => false, "inclusive" => true]);
			}
		}
		
		if (sizeof($categories) == 0) {
			return "";
		}

		$result = "";
		
		$result = ".and(";
		$result .= $data->$key->condition . "(";
		foreach ($categories AS $index=>$value) {
			$result .=  "rule(CATEGORY).field('c_categories').path(";
			$result .= "'" . $value . "'";
			$result .= ").count(2)";
			if ($index < sizeof($categories) -1) {
				$result .= ",";
			}
		}
		$result .= ")";
		$result .= ")";
		
		return $result;
	}
	public function handleBrowsers($data) {
		$result = "";
		
		if (property_exists($data, "browsers") && sizeof($data->browsers) > 0) {
			$result .= ".and(rule(KEYVALUE).key('browser.group').values([";
			$result .= implode(", ", array_map(function ($item) {
						return "'" . strtoupper($item) . "'";
					}, $data->browsers));
			$result .= "]))";
		}
		return $result;
	}

	public function handleVisit ($data) {
		$result = "";
		
		if (property_exists($data, "visit")) {
			
			if ("first" === $data->visit) {
				$result .= ".and(rule(FIRSTVISIT).site('$this->the_site'))";
			} else if ("returning" === $data->visit) {
				$result .= ".not(rule(FIRSTVISIT).site('$this->the_site'))";
			}
			
		}
		return $result;
	}

	public function handleEvent ($data) {
		$result = "";
		
		if (property_exists($data, "events") && sizeof($data->events) > 0) {
			$result .= ".and(or(";
			$result .= implode(", ", array_map(function ($event) {
						return "rule(EVENT).site('$this->the_site').event('$event').count(1)";
					}, $data->events));
			$result .= "))";
		}
		return $result;
	}

	public function handleDevices ($data) {
		$result = "";
		
		if (property_exists($data, "devices") && sizeof($data->devices) > 0) {
			$result .= ".and(rule(KEYVALUE).key('os.type').values([";
			$result .= implode(", ", array_map(function ($item) {
						return "'" . strtoupper($item) . "'";
					}, $data->devices));
			$result .= "]))";
		}
		return $result;
	}

	public function handleOperationSystems ($data) {
		$result = "";
		
		if (property_exists($data, "os") && sizeof($data->os) > 0) {
			$result .= ".and(rule(KEYVALUE).key('os.group').values([";
			$result .= implode(", ", array_map(function ($item) {
						return "'" . strtoupper($item) . "'";
					}, $this->updateOperationSystems($data->os)));
			$result .= "]))";
		}
		return $result;
	}
	private function updateOperationSystems ($os) {
		if (in_array("mac", $os)) {
			$os[] = "MAC_OS_X";
			$os[] = "MAC_OS";
		}

		return $os;
	}

}
