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
  if(!com_is_active('OssnServices')){
  ?>
	<div class="alert alert-warning"><?php echo ossn_print('ssdkv5:ossnservices:required');?></div>
  
  <?php
  		return;
  } 
  $key = ossn_services_apikey();
  if(empty($key) || !$key || strlen($key) < 10){
		ossn_mobileapp_regen_key();
  }
 ?>
 <div class="margin-top-10">
 	<div class="alert alert-info"><?php echo ossn_print('ssdkv5:notes');?></div>
    <textarea readonly="readonly" style="height:100px;min-height:100px;"><?php echo SDKv5::genenToken();?></textarea>
 </div>
 <div>
 	<label><strong><?php echo ossn_print('ssdkv5:showicons');?></strong></label>
 	<?php
		echo ossn_plugin_view('input/dropdown', array(
				'name' => 'show_icons',
				'value' => $params['settings']->show_icons,
				'options' => array(
					'' => "",				   
					'yes' => ossn_print('ssdkv5:yes'),				   
					'no' => ossn_print('ssdkv5:no'),				   
				),
		));
	?>
 </div>
 <div>
 	<label><?php echo ossn_print('ssdkv5:allow:singup');?></label>
 	<?php
		echo ossn_plugin_view('input/dropdown', array(
				'name' => 'allow_registration',
				'value' => $params['settings']->allow_registration,
				'options' => array(
					'' => "",				   
					'yes' => ossn_print('ssdkv5:yes'),				   
					'no' => ossn_print('ssdkv5:no'),				   
				),
		));
	?>    
 </div>
 <input type="submit" value="<?php echo ossn_print('save');?>" class="btn btn-success" />