<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
?>
<div class="row">
	<div class="col-md-12">
    	<div class="ossn-page-contents">
        	<p><?php echo ossn_print('ssdkv5:ui:notes');?></p>
            <p><strong><?php echo ossn_print('ssdkv5:ui:hostname');?> </strong><?php echo mobile_api_host();?></p>
            <p><strong><?php echo ossn_print('ssdkv5:ui:username');?> </strong><?php echo ossn_print('ssdkv5:ui:yourusername');?></p>
            <p><strong><?php echo ossn_print('ssdkv5:ui:password');?> </strong><?php echo ossn_print('ssdkv5:ui:yourpassword');?></p>
            <a target="_blank" href="https://play.google.com/store/apps/details?id=softlab24.app.ossn"><img src="<?php echo ossn_site_url();?>components/SSDKv5/images/playstore.png"/></a>
 			<a target="_blank" href="https://itunes.apple.com/app/social-network-client/id1328401266"><img src="<?php echo ossn_site_url();?>components/SSDKv5/images/ios-store.png"/></a>           
        </div>
    </div>
</div>