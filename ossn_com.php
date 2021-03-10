<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
define('SOFTLAB24_SDK_V5', ossn_route()->com . 'SSDKv5/');
require_once(SOFTLAB24_SDK_V5 . 'classes/SSDKv5.php');
require_once(SOFTLAB24_SDK_V5 . 'classes/Wall.php');
/**
 * Initlize the SDKv3
 *
 * @param null
 * 
 * @return void
 */
function softlab24_sdk_v5_init() {
		ossn_register_com_panel('SSDKv5', 'settings');
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('ossn/mobile/settings', SOFTLAB24_SDK_V5 . 'actions/settings.php');
		}		
		$component = new OssnComponents;
		$setting = $component->getSettings("SSDKv5");
		if(isset($setting) && isset($setting->show_icons) && $setting->show_icons == 'yes') {
				ossn_extend_view('ossn/page/footer/contents', 'ssdkv5/mobile');
				ossn_register_page('mobileapp', 'ossn_mobileapp_page');
				
				ossn_register_callback('message', 'created', 'ossn_message_created_app');
				ossn_register_callback('like', 'created', 'ossn_like_created_app');
				ossn_register_callback('annotations', 'created', 'ossn_comment_created_app');				
		}
		ossn_add_hook('services', 'methods', 'ssdk5_allow_registeration');
}
/**
 * Notify the SDK if some message is created.
 *
 * @param string $callback The name of callback
 * @param string $type The callback type
 * @param array $params Option values
 * 
 * @return void
 */
function ossn_message_created_app($callback, $type, $params) {
		$SDK = new SDKv5;
		$SDK->messageCreated($params);
}
/**
 * Notify the SDK if someone comment his item.
 *
 * @param string $callback The name of callback
 * @param string $type The callback type
 * @param array $params Option values
 * 
 * @return void
 */

function ossn_comment_created_app($callback, $type, $params){
			$object	= ossn_get_object($params['subject_guid']);
			$annotation = ossn_get_annotation($params['annotation_guid']);
			if($object && $annotation && $annotation->type == 'comments:post'){
						$owner_guid = $object->owner_guid;
						$owner      = ossn_user_by_guid($owner_guid);
						if($owner && !empty($owner_guid)){
								$vars['message_to'] = (new Ossn\Component\OssnServices())->setUser($owner, true);
								$vars['message'] = ossn_print('ssdkv5:commentitem', array(ossn_loggedin_user()->first_name));
								
								$SDK = new SDKv5;
								$SDK->messageCreated($vars);
						}							
			}
}
/**
 * Notify the SDK if someone like his item.
 *
 * @param string $callback The name of callback
 * @param string $type The callback type
 * @param array $params Option values
 * 
 * @return void
 */
function ossn_like_created_app($callback, $type, $params){
			switch($params['type']){
					case 'like:post':
						$object	= ossn_get_object($params['subject_guid']);
						if($object){
							$owner_guid = $object->owner_guid;	
						}
						break;
					case 'like:annotation':
						$annotation	= ossn_get_annotation($params['subject_guid']);
						if($annotation){
							$owner_guid = $annotation->owner_guid;	
						}					
						break;
			}
			$owner = ossn_user_by_guid($owner_guid);
			if($owner && !empty($owner_guid)){
				$vars['message_to'] = (new Ossn\Component\OssnServices())->setUser($owner, true);
				$vars['message'] = ossn_print('ssdkv5:likeditem', array(ossn_loggedin_user()->first_name));
				
				$SDK = new SDKv5;
				$SDK->messageCreated($vars);
			}
}
/**
 * Show a page to user from where they can download app
 *
 * @param null
 * 
 * @return void
 */
function ossn_mobileapp_page() {
		$title               = ossn_print('ssdk:mobileapp');
		$contents['content'] = ossn_plugin_view('ssdkv5/mobile_page');
		$content             = ossn_set_page_layout('newsfeed', $contents);
		echo ossn_view_page($title, $content);
}
/**
 * Re-generate the api key
 *
 * @return void
 */
function ossn_mobileapp_regen_key(){
	 $component = new OssnSite; 
	 $gen = new \Ossn\Component\OssnServices();
	 $key = $gen->genKey();
	 return $component->setSetting('com:ossnservices:apikey', $key);	
}
/**
 * Get the hostname
 *
 * @return string
 */
function mobile_api_host(){
		$url = ossn_site_url();
		$url = parse_url($url);
		return str_replace("www.", '', $url['host']);
}
function ssdk5_allow_registeration($hook, $type, $methods, $params) {
		$methods['v1.0'][] = 'allow_registration';
		return $methods;
}
ossn_register_callback('ossn', 'init', 'softlab24_sdk_v5_init');