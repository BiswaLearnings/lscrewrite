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
// @Created by biswakalyana Mohanty                                                      //
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
require_once __SITE_PATH . '/libs/form_handler.php';

$form = new lscform();
$form->openForm(array('method' => 'POST', 'action' => '', 'id' => 'manageAccount', 'name' => 'manageAccount'));
$form->addInline('<div class="jquery-table" >');
$form->openTable(array('name'=>'accountList','cellspacing'=>'0','border'=>'0','class'=>'display','id'=>'example'));
$form->openTableHeader();
$form->openTableRow();
$form->addTableHead($lang['accounts']);
$form->addTableHead($lang['edit']);
$form->addTableHead($lang['role']);
$form->closeTableRow();

$form->closeTableHeader();
$form->openTableBody();

if (!empty($data)) {
    foreach($data as $key => $account) {
		$accountId=$account['id'];   
		
		$form->openTableRow(array('class'=>'odd_gradeX','id'=>'2'));   
		$form->openTableColumn(array('style'=>'width:70%'));
		$form->addInline('<a href="?load=account/viewAccount/'.$accountId.'"><b>'.$account["accountname"].'</b></a>');
		$form->closeTableColumn();
		
		$form->openTableColumn();
		$form->addInline('<a href="?load=account/showEditAccount/'.$accountId.'"><u>Edit Account</u></a>');
		$form->closeTableColumn();
		
		$form->openTableColumn();
		$form->addInline('<a href="?load=roles/roleList/'.$accountId.'"><u>Role</u></a>');
		$form->closeTableColumn();
		$form->closeTableRow();
     }
}
$form->closeTableBody();
$form->closeTable();
$form->addInline('</div>');
$form->closeForm();
echo $form;
?>
                
            
