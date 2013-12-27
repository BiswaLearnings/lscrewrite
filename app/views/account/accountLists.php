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
// @Modified by Venkatakrishnan   (27th Feb 2013)                                       //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                             	   										//
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php
include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/libs/form_handler.php';
require_once __SITE_PATH . '/libs/LSCAccordion.php';

$session = new Session();
if($session->getUserLogin()){
}

?>
<div style="padding-bottom: 5px; padding-left: 5px;" class="style1">
	<div class="breadcrumb">
		<span class="left"></span>
		<ul>
			<li><a href="?load=account/accountlists">Home</a></li>
			<li><a href="?load=account/viewAccount">Accounts</a></li>
			<li><a href="#" class="active">List of Accounts</a></li>
		</ul>
		<span class="right"></span>
	</div>
</div>
<div class="mcright">
    <div class="mc01">
        <div id="tab-container">

                <?php
                $form = new lscform();
                $form->openForm(array('action' => '#', 'name' => 'addAccountForm'));
                $form->addInline('<div id="controlHeader"><div id="addNewAccount">');
                $form->addButton('button', array('name'=>'addAccount', 'value'=>'Add New Account', 'onclick'=>sprintf('redirectToURL(\'%s?load=/account/addAccountForm\');', WEB_PATH)));
                $form->addInline('</div><div id="searchControls">');
                $form->addButton('button', array('name'=>'search', 'value'=>'Search', 'onclick' => 'isEmpty(\'.searchText\')'));
                $form->addInput("text", array('name' => 'searchText', 'class' => 'searchText'));
                $form->addInline('</div></div>');
                $form->closeForm();
                echo $form;
                ?>
            
            <div class="clear"></div>
            <h2 id="Intro"><img src="<?php echo WEB_PATH; ?>/content/images/lsc_notification.jpg" width="30" height="30" />&nbsp;<font color="#850057">Accounts<hr style="color: #3e6680; size: 2"></font></h2>
            <?php

            // The accordion code
            $accordion = new LSCAccordion();
            foreach($data as $row)
            {
                $accordion->Add_HeaderAndContent($row["account_name"], $row["account_description"],
                    array(new HeaderOption('Edit Account', ''), new HeaderOption('Roles', sprintf('?load=roles/roleList/%s', $row["id"]))));
            }
            $accordion->RenderAccordion();
            ?>

        </div>
    </div>
</div>
<br>
<?php
include(__SITE_PATH . '/app/views/footer.php');
?>