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
<script type="text/javascript">

var label1 = document.getElementById("OrgUnitHead");
var label2 = document.getElementById("OrgUnitHeadSign");
var label3 = document.getElementById("accountLead");
var label4 = document.getElementById("accountLeadSign");
function getOrgDesignation(designation){
	if(designation==1){
			label1.getElementsByTagName('label')[0].innerHTML = "<b>Org Unit Head</b>";
			label2.getElementsByTagName('label')[0].innerHTML = "<b>Upload Org Unit Head Signature</b>";
	}
	else if (designation==2){
			label1.getElementsByTagName('label')[0].innerHTML = "<b>Global Account Executive</b>";
			label2.getElementsByTagName('label')[0].innerHTML = "<b>Upload Global Account Executive Signature</b>";
	}
}
function getLeadDesignation(designation){
	if(designation==1){
			label3.getElementsByTagName('label')[0].innerHTML = "<b>Vertcal head</b>";
			label4.getElementsByTagName('label')[0].innerHTML = "<b>ipload Vertical Head Signature</b>";
	}
	else if (designation==2){
			label3.getElementsByTagName('label')[0].innerHTML = "<b>Account Lead</b>";
			label4.getElementsByTagName('label')[0].innerHTML = "<b>Upload Account Lead Signature</b>";
	}
	else if (designation==3){
			label3.getElementsByTagName('label')[0].innerHTML = "<b>Global Program Executive</b>";
			label4.getElementsByTagName('label')[0].innerHTML = "<b>Upload Global Program Executive Signature</b>";
}
}
	$(document).ready(function() {
		$("#tabs").tabs();
	});
function disableSendLink(){
	
}

</script>

<?php
                //TO DO

require_once __SITE_PATH . '/libs/form_handler.php';
include_once __SITE_PATH . '/lang/lang.php';

$regioncombo = array();
$verticalcombo = array();
$scopecombo = array();
$orgDesigcombo = array();
$leadDesigcombo = array();
$statuscombo = array();
foreach($data as $dataKey=>$dataValue){
	if ($dataKey=='fieldValue'){
		$fieldvalues=$dataValue;
	}
	if ($dataKey=='combos') {
		$combos=$dataValue;
	}
	if ($dataKey=='message') {
		$message=$dataValue;
	}
	
}
foreach($combos as $combovalues ){
	if($combovalues['type']=='Region'){
    	$regioncombo[$combovalues['id']]=$combovalues['Meta_value'];
    }
    elseif ($combovalues['type']=='Account Vertical'){
    	$verticalcombo[$combovalues['id']]=$combovalues['Meta_value'];
    }
    else if($combovalues['type']=='Primary Engagement Scope'){
    	$scopecombo[$combovalues['id']]=$combovalues['Meta_value'];
    }
    else if($combovalues['type']=='Org Unit Head Designations'){
    	$orgDesigcombo[$combovalues['id']]=$combovalues['Meta_value'];
    }
	else if($combovalues['type']=='Account Lead Designations'){
    	$leadDesigcombo[$combovalues['id']]=$combovalues['Meta_value'];
    }
	else if($combovalues['type']=='Account Status'){
    	$statuscombo[$combovalues['id']]=$combovalues['Meta_value'];
    }
}

              
/****Starting of form..****/
$form = new lscform();
$form->openForm(array('action' => '?load=account/addAccount', 'name' => 'addAccountForm', 'id' => 'addAccountForm'));

$form->openTable();
$form->openTableRow();
$form->openTableColumn(array('valign'=>'top','style'=>'padding-left:20px;'));
/** 
 * First column of fields
 */
$form->openTable();
/** Account Name textbox  **/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Account Name <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Name ','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn();
if (!empty($fieldvalues['accountname'])){
	$value=$fieldvalues['accountname'];
}
else { $value = null; }
$form->addInput('text', array('name' => 'accountname','value' => $value,'style' => 'width: 15em', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->closeTableColumn();
$form->closeTableRow();

/** "Account Acronym" textbox  **/  
$form->openTableRow();
$form->openTableColumn();     
$form->addLabel('Account Acronym <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Acronym: ','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn();
if (!empty($fieldvalues['accountshortname'])){
   	$value=$fieldvalues['accountshortname'];
}
else { $value = null; }
$form->addInput('text', array('name' => 'accountshortname','value' => $value,'style' => 'width: 15em', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->closeTableColumn();
$form->closeTableRow();


/** Account Description text area  **/  
$form->openTableRow();
$form->openTableColumn(); 
$form->addLabel('Account Description <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Description:','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn();
if (!empty($fieldvalues['accountdescription'])){
	$value=$fieldvalues['accountdescription'];
}
else { $value = null; }
$form->addTextarea($value, array('name' => 'accountdescription','style' => 'width: 15em;height: 5em', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->closeTableColumn();
$form->closeTableRow();

/** Region Dropdown **/       
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Region <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Region: ','style' => 'width: 15em')); 
$form->closeTableColumn();
$form->openTableColumn();          
if (!empty($fieldvalues['regionid'])){
      $value=$fieldvalues['regionid'];
}
else { $value = null; }
$form->openSelect(array('name'=>'regionid','style' => 'width: 15em', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select a Region',array('value'=>''));
foreach($regioncombo as $key=>$val ){
	if($key==$value){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        	$form->addOption($val,array('value'=>$key));
    	}
} 
$form->closeSelect();
$form->closeTableColumn();
$form->closeTableRow();


/** Account Vertical **/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Vertical <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Vertical: ','style' => 'width: 15em'));  
$form->closeTableColumn();
$form->openTableColumn();              
if (!empty($fieldvalues['accountverticalid'])){
    $value=$fieldvalues['accountverticalid'];
}
else { $value = null; }
$form->openSelect(array('name'=>'accountverticalid','style' => 'width: 15em', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select a vertical',array('value'=>''));
foreach($verticalcombo as $key=>$val ){
	if($key==$value){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
} 
$form->closeSelect();
$form->closeTableColumn();
$form->closeTableRow();

/** Primary engagement scope **/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Primary Engagement Scope <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Primary Engagement Scope:','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn(); 
if(!empty ($fieldvalues['primaryengagmentscope'])){
	$value=$fieldvalues['primaryengagmentscope'];
}
else { $value = null; }
$form->openSelect(array('name'=>'primaryengagmentscope','style' => 'width: 15em', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select scope',array('value'=>''));
foreach($scopecombo as $key=>$val ){
	if($key==$value){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
}
$form->closeSelect();
$form->closeTableColumn();
$form->closeTableRow();


/** Account Status **/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Account Status <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Account Status:','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn(); 
if(!empty ($fieldvalues['accountstatusid'])){
	$value=$fieldvalues['accountstatusid'];
}
else { $value = null; }
$form->openSelect(array('name'=>'accountstatusid','style' => 'width: 15em', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select status',array('value'=>''));
foreach($statuscombo as $key=>$val ){
	if($key==$value){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
}
$form->closeSelect();
$form->closeTableColumn();
$form->closeTableRow();


/** Already Supported by CSC India radio button **/
$form->openTableRow();
$form->openTableColumn();
$form->addlabel('Already Supported by CSC India? <font color="red">&nbsp;&nbsp;*</font>',array('for'=>'Already Supported by CSC India?','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn(); 
if (!empty($fieldvalues['supportedinindia'])){
     if ($fieldvalues['supportedinindia']=='Yes'){
     	$form->addInput('radio', array('name'=>'supportedinindia','value'=>'Yes','checked'=>'checked','style' => 'width: 1em;'));
        $form->addInline('&nbsp;&nbsp; Yes &nbsp;&nbsp;&nbsp;&nbsp;');  
        $form->addInput('radio', array('name'=>'supportedinindia','value'=>'No','style' => 'width: 1em;'));
        $form->addInline('&nbsp;&nbsp; No');
	}
    else if ($fieldvalues['supportedinindia']=='No'){
    	$form->addInput('radio', array('name'=>'supportedinindia','value'=>'Yes','style' => 'width: 1em;'));
        $form->addInline('&nbsp;&nbsp; Yes &nbsp;&nbsp;&nbsp;&nbsp;');
        $form->addInput('radio', array('name'=>'supportedinindia','value'=>'Yes','checked'=>'checked','style' => 'width: 1em;'));
        $form->addInline('&nbsp;&nbsp;No');
    }
}
else { 
   $form->addInput('radio', array('name'=>'supportedinindia','value'=>'Yes','style' => 'width: 1em;'));
    $form->addInline('&nbsp;&nbsp; Yes &nbsp;&nbsp;&nbsp;&nbsp;');
    $form->addInput('radio', array('name'=>'supportedinindia','value'=>'No','style' => 'width: 1em;'));
    $form->addInline('&nbsp;&nbsp;No');
     
}   
$form->closeTableColumn();
$form->closeTableRow();
$form->closeTable();

$form->closeTableColumn();

/*
 * second column of fields
 */

$form->openTableColumn(array('valign'=>'top','style'=>'padding-left:20px;'));

$form->openTable();
/** Account Executive **/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Account Exec.(For Region incase of Global account) <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Exec.(For Region incase of Global account)','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn(); 
if (!empty($fieldvalues['Accountexecutiveglobalid'])){
	$value=$fieldvalues['Accountexecutiveglobalid'];
}
else { $value = null; }
$form->addInput('text', array('name' => 'Accountexecutiveglobalid','value' => $value,'style' => 'width: 10em;', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->closeTableColumn();
$form->closeTableRow();

/** Account Lead in India **/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Account Lead in India <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Lead in India','style' => 'width: 15em'));
$form->closeTableColumn();
$form->openTableColumn();
if (!empty($fieldvalues['accountleadinindia'])){
	$value=$fieldvalues['accountleadinindia'];
}
else { $value = null; }
$form->addInput('text', array('name' => 'accountleadinindia','value' => $value,'style' => 'width: 10em;', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->closeTableColumn();
$form->closeTableRow();


/**LSC Team Admin Representative**/

$form->addInline('<div id="lscAdmin">');
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('LSC Admin Representative <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'LSC Admin Representative'));
$form->closeTableColumn();
$form->openTableColumn();
if (!empty($fieldvalues['LSCadmin'])){
    $value=$fieldvalues['LSCadmin'];
}
else { $value = null; }
$form->addInput('text', array('name' => 'LSCadmin','value' => $value,'style' => 'width: 10em;', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->closeTableColumn();
$form->closeTableRow();
$form->addInline('</div>');

/** Account Logo Image File**/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Account Logo Image File <font color="red">&nbsp;&nbsp;*</font>',array('for'=>'Account Logo Image File'));
$form->closeTableColumn();
$form->openTableColumn();
$form->addInput('file',array('name'=>'accountlogo'));
$form->closeTableColumn();
$form->closeTableRow();
$form->closeTable();

$form->closeTableColumn();

$form->openTableColumn(array('valign'=>'top','style'=>'padding-left:20px;'));
// Create the Tab layout and Render
$tabsHtml = '<div id="tabs" ><ul><li><a href="#tabs-1">Level 1 Head</a></li><li><a href="#tabs-2">Level 2 Head</a></li></ul><div id="tabs-1">';
$form->addInline($tabsHtml);

/** Org unit head designation dropdown **/
$form->addInline('<div id="orgUnitHeadDesig">');
$form->addLabel('Org unit head designation <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Org unit head designation:'));   
if(!empty ($fieldvalues['orgunitdesignation'])){
	$value=$fieldvalues['orgunitdesignation'];
}
else { $value = null; }
$form->openSelect(array('name'=>'orgunitdesignation','style' => 'width: 15em;','onchange'=>'getOrgDesignation(this.value)', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select Org Unit Head Designation',array('value'=>''));
foreach($orgDesigcombo as $key=>$val ){
	if($key==$value){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
}
$form->closeSelect();
$form->addInline('</div>');

/** Org unit head  **/
$form->addInline('<div id="OrgUnitHead">');
if(!empty ($fieldvalues['orgunitdesignation'])){
	$label=$orgDesigcombo[$fieldvalues['orgunitdesignation']];
}
else { $label = "Org Unit Head"; }
$form->addLabel($label.' <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Org Unit Head'));
if (!empty($fieldvalues['orgunithead'])){
	$value=$fieldvalues['orgunithead'];
}
else { $value = null; }
$form->addInput('text', array('name' => 'orgunithead','value' => $value,'style' => 'width: 10em;', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px"  alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->addInline('</div>');

/** Org unit head signature **/
$form->addInline('<div id="OrgUnitHeadSign">');
$form->addLabel('Upload Signature', array('for' => 'Upload Signature1'));
if(!empty($fieldvalues['orgunitsignature'])){
	print_r($fieldvalues['orgunitsignature']);
	$form->addInline(sprintf("<img id='orgUnitHeadSignature' width='150px' height='40px' style='border: #000000 solid thin;' src='data:image/jpeg;base64,%s' />", base64_encode(addslashes(file_get_contents($fieldvalues["orgunitsignature"]["tmp_name"])))).'<br/>');
	$form->addlabel('',array('for'=>''));
}
$form->addInput('file', array('name'=>'orgunitsignature','id'=>'uploadSign1','style' => 'width: 15em;','onchange'=>"disableSendLink()"));
$form->addInline('<br/>');
$form->addlabel('',array('for'=>''));
$form->addInput('button', array('name'=>'mailLink_org','value'=>'Send a link'));
$form->addInline('</div></div><div id="tabs-2">');


/*Signature 2 */

/** Account lead designation dropdown **/

$form->addLabel('Account lead designation <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Account lead designation:'));   
if(!empty ($fieldvalues['Accountdesignation'])){
	$value=$fieldvalues['Accountdesignation'];
}
else { $value = null; }
$form->openSelect(array('name'=>'Accountdesignation','style' => 'width: 15em;','onchange'=>'getLeadDesignation(this.value)', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select Account Lead Designation',array('value'=>''));
foreach($leadDesigcombo as $key=>$val ){
	if($key==$value){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
}
$form->closeSelect();

/** Account Lead  **/
$form->addInline('<div id="accountLead">');
if(!empty ($fieldvalues['Accountdesignation'])){
	$label=$leadDesigcombo[$fieldvalues['Accountdesignation']];
}
else { $label = 'Account Lead'; }
$form->addLabel($label.' <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Lead'));
if (!empty($fieldvalues['accountleadid'])){
	$value=$fieldvalues['accountleadid'];
}
else { $value = null; }
$form->addInput('text', array('name' => 'accountleadid','value' => $value,'style' => 'width: 10em;', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));

$form->addInline('</div>');
$form->closeSelect();

/** Account Lead signature **/
$form->addInline('<div id="accountLeadSign">');
$form->addLabel('Upload Signature ', array('for' => 'Upload Signature'));
if (!empty($fieldvalues['accountsignature'])){
	$value=$fieldvalues['accountsignature'];
}
else { $value = null; }
$form->addInput('file', array('name'=>'accountsignature','style' => 'width: 15em;','oninput'=>'disableSendLink(this.value)'));
$form->addInline('<br/>');
$form->addlabel('',array('for'=>''));
$form->addInput('button', array('name'=>'mailLink_account','value'=>'Send a link'));
$form->addInline('</div></div></div>');


/** Submit button  **/
$form->addInline('<br><br><br><p align=right>');
$form->addInput('submit', array('name' => 'submit', 'value' => 'Create Account' ));
$form->addInline('&nbsp;&nbsp;');
$form->addInput('submit', array('name' => 'cancel', 'value' => 'Cancel', 'style' => ''));
$form->addInline('</p>'); 
$form->closeTableColumn();
$form->closeTableRow();
$form->CloseTable();           
$form->closeForm();            
echo $form;

/** Error messages **/
$errorMessage='';
if (!empty($message)) {
    	$errorMessage = implode($message, '\n');
    
}

if(count($message) > 0)
{
    echo '<script type="text/javascript"> $(document).ready(function(){ alert("Please correct the following errors: \n\n'.$errorMessage.'"); });</script>';
} 

         
?>

