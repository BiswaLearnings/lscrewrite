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
// @Created by Biswakalyana Mohanty	                                                    //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////

include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
?>

 <div id="pane">
    <div id="submenus">
        <div class="submenu active"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/view.png" height="10" width="10" style="border: none; padding-right: 5px;"/><a href="?load=account/showmanageAccount"><?php echo $lang['manage_accounts'];?></a></div>
        <div class="submenu"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/settings.png" height="10" width="10" style="border: none; padding-right: 5px;"/><a href="?load=account/showCreateAccount"><?php echo $lang['add_new_account'];?></a></div>
    </div>
 	<div id="userid"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/access.png" height="15" width="15" style="border: none; padding-right: 5px; padding-top: 5px"/>
     <?php
        $session = new Session();
        $session->welcome();
        ?>
    </div>     
    <hr/>
 	<div class="bigContainer">
        <strong>
        	<?php 
	        echo sprintf("<img id='accountLogo' width='15px' src='data:image/jpeg;base64,%s' />", base64_encode($data['accountDetails']["accountlogo"]));
	        echo $data['accountDetails']['accountname'];
	        ?>
        </strong><hr/>
 
  <?php
                  //TO DO
                  include_once __SITE_PATH.'/templates/account/edit_account_form.php';
                ?>

        </div>
    </div>

<br>
<?php
include(__SITE_PATH . '/app/views/footer.php');
?>