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
// @Created by: Biswakalyana Mohanty                                                         //
// @date: 4/10/13  12:32 PM                                                   	   		//
// @version: 1.0								       									//
// @description:                                                                	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/form_handler.php';
?>
<div id="pane">
        <div id="submenus">
        <div class="submenu"><a href="#"><?php echo "Modules" ;?></a></div>
        <div class="submenu active "><a href="#"><?php echo $lang['skillport_assessment'];?></a></div>
        </div>
        <div id="userid"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/access.png" height="15" width="15" style="border: none; padding-right: 5px; padding-top: 5px"/>
              <?php
        $session = new Session();
        $session->welcome();
        ?>
        </div>
        <hr />
        <div class="bigContainer">
            <strong><?php echo $data["module_name"];?></strong><hr/>
            <?php
            include_once __SITE_PATH.'/templates/user_quiz/skillport_details_form.php';
            ?>
        </div>
        </div>
      <?php
include(__SITE_PATH . '/app/views/footer.php');
?>