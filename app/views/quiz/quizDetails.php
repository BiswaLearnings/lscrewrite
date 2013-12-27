<?php
//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
// NOTICE OF COPYRIGHT                                                                  //
//                                                                                      //
//                                                                                      //
//Copyright (C) 2010 onwards  Computer Sciences Corporation  http://www.csc.com         //
//                                                                                      //
// This program is free software: you can redistribute it and/or modify                 //
// it under the terms of the GNU General Public License as published by                 //
// the Free Software Foundation, either version 3 of the License, or                    //
// (at your option) any later version.                                                  //
//                                                                                      //
// This program is distributed in the hope that it will be useful,                      //
// but WITHOUT ANY WARRANTY; without even the implied warranty of                       //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                        //
// GNU General Public License for more details.                                         //
//                                                                                      //
//  You should have received a copy of the GNU General Public License                   //
//  along with this program.If not, see <http://www.gnu.org/licenses/>.                 //
//                                                                                      //
// @Created by: Venkatakrishnan                                                         //
// @date: 4/8/13  11:31 AM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php
require_once __SITE_PATH . '/libs/form_handler.php';
include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
?>

    <div id="pane">
        <div id="submenus">
            <div class="submenu"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/back.png" height="13" width="13" style="border: none; padding-right: 5px;"/><a href="#"><?php echo $lang['back_to'].$lang['assessments'];?></a></div>
            <div class="submenu active"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/details.png" height="13" width="13" style="border: none; padding-right: 5px;"/><a href="#"><?php echo $lang['quiz_details'];?></a></div>
            <div class="submenu"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/results.png" height="13" width="13" style="border: none; padding-right: 5px;"/><a href="#"><?php echo $lang['quiz_results'];?></a></div>
        </div>
        <div id="userid"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/access.png" height="15" width="15" style="border: none; padding-right: 5px; padding-top: 5px"/>
            <?php
            $session = new Session();
            $session->welcome();
            ?>
        </div>
        <hr />
        <div class="bigContainer">
            <strong><?php echo $lang['Quiz'];?></strong><hr/>
            <?php
                include_once __SITE_PATH.'/templates/quiz/quizDetailsTemplate.php';
            ?>
        </div>

<?php
include(__SITE_PATH . '/app/views/footer.php');
?>