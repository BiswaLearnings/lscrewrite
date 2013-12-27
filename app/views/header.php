<?php
//////////////////////////////////////////////////////////////////////////////////////////
//                                                                       	   			//
// NOTICE OF COPYRIGHT                                                   	   			//
//                                                                       	   			//
//                                                                       	   			//
//Copyright (C) 2010 onwards  Computer Sciences Corporation  http://www.csc.com    		//
//                                                                       	   			//
// This program is free software: you can redistribute it and/or modify  	   			//
// it under the terms of the GNU General Public License as published by  	   			//
// the Free Software Foundation, either version 3 of the License, or     	   			//
// (at your option) any later version.                                   	   			//
//                                                                                 		//
// This program is distributed in the hope that it will be useful,                 		//
// but WITHOUT ANY WARRANTY; without even the implied warranty of                  		//
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                   		//
// GNU General Public License for more details.                                    		//
//                                                                                 		//
//  You should have received a copy of the GNU General Public License              		//
//  along with this program.If not, see <http://www.gnu.org/licenses/>.            		//
//							                           									//
// @Created by Achappan Mahalingam                                                      //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                              	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once (__SITE_PATH . '/lang/lang.php');
require_once (__SITE_PATH . '/libs/LSCSessionHandler.php');
require_once (__SITE_PATH . '/libs/db.php');
require_once (__SITE_PATH . '/libs/Session.php');
$session = new Session();
$loginUserLevel = $session->getUserLevel();

if ($loginUserLevel == USER_LEVEL)
{
	$adminUser = 'N';
}
else
{
	$adminUser = 'Y';
}		
 
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1;charset=windows-1252" />
    <title>LSC</title>
    <link href="<?php echo WEB_PATH; ?>/content/css/new_styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo WEB_PATH; ?>/content/images/menu_assets/styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo WEB_PATH.'/content/Tabs/jquery-ui.css'?>" />
    <script src="<?php echo WEB_PATH; ?>/content/js/jquery-1.9.1.min.js" charset=""></script>
    <script src="<?php echo WEB_PATH.'/content/Tabs/jquery-ui.js'?>"></script>
    <script src="<?php echo WEB_PATH; ?>/content/js/CommonScript.js" charset=""></script>
</head>
<body id="tsmenu1">
<div id="header">
    <img src="<?php echo WEB_PATH; ?>/content/images/images_files/header_left.png" width="380" height="80" style="position:relative; float:left"/>
    <img src="<?php echo WEB_PATH; ?>/content/images/images_files/header_right.png" width="80" height="80" style="position: absolute; float:left; margin-left: 20px"/>
    <img src="<?php echo WEB_PATH; ?>/content/images/images_files/stayahead.png" width="250" height="40" style="position:relative; float:right; margin-top: 20px;"/>
</div>
<div id="content" class="constant-width">
    <div id='cssmenu'>
        <ul>
        	<?php 
        	if ($adminUser == 'Y')
        	{
        	?>	
            <li><a href="<?php echo WEB_PATH; ?>"><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/Home.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['home'];?></span></a></li>
            <li><a href='?load=account/showmanageAccount'><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/accounts.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['accounts'];?></span></a></li>
            <li><a href='?load=module/showManageModules'><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/modules.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['modules'];?></span></a></li>
            <li><a href='?load=resource/addResource'><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/resources.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['resources'];?></span></a></li>
            <li><a href='#'><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/notifications.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['notifications'];?></span></a></li>
            <li class='last'><a href='?load=settings/settingsview'><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/settings.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['settings'];?></span></a></li>
            <?php
        	}
        	else if ($adminUser == 'N')
        	{	 
            ?>
            <li><a href="<?php echo WEB_PATH; ?>"><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/Home.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['home'];?></span></a></li>
			<li><a href="<?php echo sprintf('?load=userModules/userAssignedTasks/%s', 'roles') ?>"><span><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/resources.png" height="15" width="15" style="border: none; padding-right: 5px;"/><?php echo $lang['useractivity'];?></span></a></li>
			<?php
        	} 
			?>            
        </ul>
        
    </div>
</div>

