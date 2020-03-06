<?php

namespace TMA\ExperienceManager\Segment;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SegmentRequest {
	
	protected static $_instance = null;
 
   /**
    * get instance
    *
    * Falls die einzige Instanz noch nicht existiert, erstelle sie
    * Gebe die einzige Instanz dann zurück
    *
    * @return   Singleton
    */
   public static function getInstance()
   {
       if (null === self::$_instance)
       {
           self::$_instance = new self;
       }
       return self::$_instance;
   }

	public function load_segment($id) {
		$site = tma_exm_get_site();
		$parameters = array(
			'wpid' => $id,
			'site' => $site
		);
		
		$audience_url = "/rest/audience";
		$audience_url .= "?" . http_build_query($parameters);
		
		$request = new \TMA\ExperienceManager\TMA_Request();
		$response = $request->get($audience_url);

		if ((is_object($response) || is_array($response)) && !is_wp_error($response)) {
			$result = $response['body']; // use the content
			$data = json_decode($result);
			if (property_exists($data, "segment")){
				return $data->segment;
			}
		}
		
		return FALSE;
	}

	public function save_segment($ID, $post, $segment) {
		tma_exm_log("post data");
		tma_exm_log(json_encode($segment));

		$request = new \TMA\ExperienceManager\TMA_Request();
		$error = FALSE;
		try {
			$response = $request->post("/rest/audience", $segment);

			if ($response !== FALSE) {
				$code = wp_remote_retrieve_response_code($response);
				$body_string = wp_remote_retrieve_body($response);
				$body = json_decode($body_string);
				tma_exm_log("code " . $code);
				tma_exm_log("body " . $body_string);

				if ($code === 200) {
					if ($body->status === "ok") {
						
					} else {
						$error = new \WP_Error("error", $response->body->message);
					}
				} else {
					$error = new \WP_Error("error", "Error while accessing Experience Platform");
				}
			} else {
				$error = new \WP_Error("error", "Error while accessing Experience Platform");
			}
		} catch (Exception $ex) {
			$error = new \WP_Error("error", "error publishing audience: " . $ex->getMessage());
		} catch (\Unirest\Exception $uex) {
			$error = new \WP_Error("error", "error publishing audience: " . $uex->getMessage());
		}

		return $error;
	}

}
