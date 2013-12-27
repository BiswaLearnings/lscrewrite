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
require_once __SITE_PATH . '/libs/DBUtil.php';
?>

<div style="padding-top: 5px; padding-left: 5px;" class="style1">
    <div class="breadcrumb">
        <span class="left"></span>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Accounts</a></li>
            <li><a href="#" class="active">Add New Account</a></li>
        </ul>
        <span class="right"></span>
    </div>
</div>
<div class="mcright">
    <div class="mc01">
        <div class="clear"></div>
        <div id="tab-container">
            <h2 id="Intro"><img src="<?php echo WEB_PATH; ?>/content/images/lsc_notification.jpg" width="30" height="25" />&nbsp;<font color="#850057">Add Account<hr style="color: #3e6680; size: 2"></font></h2>
            
                <?php
                //TO DO

                require_once __SITE_PATH . '/libs/form_handler.php';

                $form = new lscform();
                $form->openForm(array('action' => '#', 'name' => 'addAccountForm'));

                if (!empty($data)) {
                    foreach ($data as $value) {
                        //TO DO
                    }
                }
                $form->addInline('<br /><br />');
                $form->addLabel('Account Name', array('for' => 'Account Name ', 'style' => 'float: left;
width: 10em;
margin-right: 1em;'));
                $form->addInline('');
                $form->addInput('text', array('name' => 'userName'));
                $form->addInline('<br /><br />');
                $form->addLabel('Account Acronym', array('for' => 'Account Acronym: ', 'style' => 'margin: 15px;'));
                $form->addInline('');
                $form->addInput('text', array('name' => 'account_acronym'));
                $form->addInline('<br /><br />');
                $form->addButton('submit', array('name' => 'submit', 'value' => 'Submit', 'style' => 'background:#0066A2;
color:white;
border-style:outset;
border-color:#0066A2;
height:30px;
width:100px;
font: bold 15px arial,sans-serif;'));
                $form->closeForm();
//echo '<div style="border: 1px solid darkgrey; text-align: center; width:430px;">';
                echo $form;
//echo '</div>';
                ?>
        </div>
    </div>
</div>

<br>
<?php
include(__SITE_PATH . '/app/views/footer.php');
?>