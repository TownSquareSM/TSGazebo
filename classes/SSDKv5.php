<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (c) SOFTLAB24 LIMITED
 * @license   http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
class SDKv5 extends OssnSystem {
		/**
		 * Get token for form
		 * 
		 * @param null
		 *
		 * @return string
		 */
		public static function genenToken() {
				$data = array(
						's' => ossn_site_url(),
						'n' => ossn_site_settings('site_name'),
						'oe' => ossn_site_settings('owner_email'),
						'v' => ossn_site_settings('site_version'),
						'k' => ossn_services_apikey(),
				);
				$data = json_encode($data);
				$data = base64_encode($data);
				return "<--- SOFTLAB24 MOBILE API REQUEST --->\r\n" . $data . "\r\n<--- SOFTLAB24 MOBILE API REQUEST END --->";
		}	
		/**
		 * Hand Shake
		 *
		 * @param string $endpoint The complete URL for endpoint
		 * @param array $options The options you want to broadcast
		 * 
		 * @return boolean|string
		 */					
		private function handShake($endpoint, array $options = array()) {
				if(empty($endpoint) || empty($options)) {
						return false;
				}
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $endpoint);
				curl_setopt($curl, CURLOPT_CAINFO, ossn_route()->www . 'vendors/cacert.pem');
				curl_setopt($curl, CURLOPT_POST, sizeof($options));
				curl_setopt($curl, CURLOPT_POSTFIELDS, $options);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($curl);
				curl_close($curl);
				return $result;
		}
		/**
		 * Notify the SDK if some message is created.
		 
		 * @param array $params Option values
		 * 
		 * @return string
		 */
		public function messageCreated(array $params = array()) {
				$params['message_from'] = (new Ossn\Component\OssnServices())->setUser(ossn_loggedin_user(), true);
				$request                = array(
						'api_key' => ossn_services_apikey(),
				);
				$vars                   = array_merge($request, array(
						'data' => base64_encode(json_encode($params))
				));
				$endpoint               = 'https://api.softlab24.com/v6-1';
				return $this->handShake($endpoint, $vars);
		}		
} //class