<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
 
 $component = new OssnComponents;
 $show_icons = input('show_icons');
 $allow_registration = input('allow_registration');
 $args = array(
			   'show_icons' => $show_icons,
			   'allow_registration' => $allow_registration,
 );
 if($component->setSettings('SSDKv5', $args)){
		ossn_trigger_message(ossn_print('ssdkv5:saved'));
		redirect(REF);
 } else {
		ossn_trigger_message(ossn_print('ssdkv5:save:error'), 'error');
		redirect(REF);	 
 }