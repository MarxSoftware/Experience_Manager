<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Modules\Ajax;

/**
 * Description of class
 *
 * @author marx
 */
class Product {
	public $id;
    public function __construct($id) {
		$this->id = $id;
	}
	
	public function get_id () {
		return $this->id;
	}
}
