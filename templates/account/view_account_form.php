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
// @Created by Biswakalyana Mohanty                                                      //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>


<?php
                //TO DO

require_once __SITE_PATH . '/libs/form_handler.php';
include_once __SITE_PATH . '/lang/lang.php';

	$form = new lscform();
	$form->openForm(array('action' => '?load=account/showEditAccount/'.$accountDetails['id'], 'name' => 'viewAccountForm'));
	
	
	$form->openTable(array('width'=>'90%','align'=>'center','border'=>0));
	$form->openTableRow();
	$form->openTableColumn(array('valign'=>'top'));
	$form->openTable(array('align'=>'center'));
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Name</b>');
	$form->closeTableColumn();
	$form->openTableColumn(array());
	$form->addInline($accountDetails["accountname"]);
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Acronym</b>');
	$form->closeTableColumn();
	$form->openTableColumn(array());
	$form->addInline($accountDetails["accountshortname"]);
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Description</b>');
	$form->closeTableColumn();
	$form->openTableColumn(array());
	$form->addInline($accountDetails["accountdescription"]);
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Region</b>');
	$form->closeTableColumn();
	$form->openTableColumn(array());
	$form->addInline($regioncombo[$accountDetails["regionid"]]);
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Is Global Account?</b>');
	$form->closeTableColumn();
	if ($accountDetails["globalaccount"]==0){
	$global= "No";
	}
	else{
	$global= "Yes";
	}
	$form->openTableColumn(array());
	$form->addInline($global);
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Vertical</b>');
	$form->closeTableColumn();
	$form->openTableColumn(array());
	$form->addInline($verticalcombo[$accountDetails["accountverticalid"]]);
	$form->closeTableColumn();
	$form->closeTableRow();
			
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Primary Engagement Scope</b>');
	$form->closeTableColumn();
	$form->openTableColumn(array());
	$form->addInline($accountDetails["primaryengagmentscope"]);
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Status</b>');
	$form->closeTableColumn();
	$form->openTableColumn(array());
	$form->addInline($statuscombo[$accountDetails["accountstatusid"]]);
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Already Supported by india?</b>');
	$form->closeTableColumn();
	if($accountDetails["supportedinindia"]==0){
	$support= "No";
	}
	else{
	$support= "Yes";
	}
	$form->openTableColumn(array());
	$form->addInline($support);
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->closeTable();
	$form->closeTableColumn();
	$form->openTableColumn();
	
	$form->openTable();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Executive (For Region in case of Global Account)</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline($accountDetails["Accountexecutiveglobalid"].'<br />');	
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Lead In India</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline($accountDetails["accountleadinindia"].'<br />');	
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>'.$orgDesigcombo[$accountDetails["orgunitdesignation"]].'</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline($accountDetails["orgunithead"].'<br />');
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>'.$orgDesigcombo[$accountDetails["orgunitdesignation"]].' Signature</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline(sprintf("<img id='orgUnitHeadSignature' width='80px' height='30px' style='border: #666666 thin; display: table-cell;' src='data:image/jpeg;base64,%s' />", base64_encode($accountDetails["orgunitsignature"])).'<br />');
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>'.$leadDesigcombo[$accountDetails["Accountdesignation"]].'</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline($accountDetails["accountleadid"].'<br />');
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>'.$leadDesigcombo[$accountDetails["Accountdesignation"]].' Signature</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline(sprintf("<img id='accountLeadSignature' width='80px' height='30px' style='border: #666666 thin; display: table-cell;' src='data:image/jpeg;base64,%s' />", base64_encode($accountDetails["accountsignature"])).'<br />');
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>LSC Admin Representative</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline($accountDetails["LSCadmin"].'<br />');
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('style'=>'text-align:right;padding-right:20px;'));
	$form->addInline('<b>Account Logo</b>');
	$form->closeTableColumn();
	$form->openTableColumn();
	$form->addInline(sprintf("<img id='accountLogo' width='80px' height='30px' style='border: #666666 thin; display: table-cell;' src='data:image/jpeg;base64,%s' />", base64_encode($accountDetails["accountlogo"])).'<br />');
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->closeTable();
	
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->openTableRow();
	$form->openTableColumn(array('colspan'=>2,'style'=>'text-align : center'));
	$form->addInput('submit', array('name' => 'edit', 'value' => 'Edit Account Details'));
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->closeTable();
 
	$form->closeForm();            
	echo $form;
	
	?>