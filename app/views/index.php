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
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>

<?php
include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
?>
    <div id="pane">
        <div id="submenus">

        </div>
        <div id="userid"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/access.png" height="15" width="15" style="border: none; padding-right: 5px; padding-top: 5px"/>
            <?php
            $session = new Session();
            $session->welcome();
            ?>
        </div>
        <hr />
        <div class="bigContainer">
            <div style="width:200px; font-size: 20px; position: relative; left:50%; margin-left: -100px;">Welcome To LSC!</div>
            <br />
            <table style="width:890px; position:relative; left:50%; margin-left: -445px;"><tr>
                <td>
                    <div class="container">
                        <strong><img src="<?php echo WEB_PATH?>/content/images/commonimages/notifications.png" height="15" width="15" style="border: none; padding-right: 5px;"/>Recent News</strong>
                        <hr />
                        Sample News 1 <br />
                        Sample News 2 <br />
                        Sample News 3 <br />
                        Sample News 4 <br />
                        Sample News 5 <br />
                    </div>
                </td>
                <td>
                    <div class="description">
                        <img src="<?php echo WEB_PATH?>/content/images/images_files/Screen1_05.png" style="margin-left : 30px"/>
                    </div>
                </td>
                <td>
                    <div class="container">
                        <strong><img src="<?php echo WEB_PATH?>/content/images/commonimages/activities.png" height="15" width="15" style="border: none; padding-right: 5px;"/>Latest Activities</strong>
                        <hr />
                        Sample Activity 1 <br />
                        Sample Activity 2 <br />
                        Sample Activity 3 <br />
                        Sample Activity 4 <br />
                    </div>
                </td>
            </tr>
            </table>
        </div>
        <?php
        include(__SITE_PATH . '/app/views/footer.php');
        ?>