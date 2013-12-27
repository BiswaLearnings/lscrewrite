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
<script type="text/javascript">



$(document).ready(function() {

    var orgUnitHeadSignChangeChecked = $('#changeOrgUnitHeadSignature:checked').val()?true:false;
    var changeAccountLeadSignatureChecked = $('#changeAccountLeadSignature:checked').val()?true:false;
   
    var requestOrgUnitHeadSignChecked = $('#requestOrgUnitHeadSignature:checked').val()?true:false;
    var requestAccountLeadSignatureChecked = $('#requestAccountLeadSignature:checked').val()?true:false;
   

    //Initial setup : Stabilize the controls based on the checkbox values
    toggleDisplay($('#orgUnitHeadSignature').length > 0 && !orgUnitHeadSignChangeChecked, 'orgUnitHeadSignature', 'orgunitsignature');
    toggleDisplay($('#accountLeadSignature').length > 0 && !changeAccountLeadSignatureChecked, 'accountLeadSignature', 'accountsignature');
    
    toggleDisplay(requestOrgUnitHeadSignChecked, 'orgUnitHeadNameEmailSection', 'orgUnitHeadSignatureFileUploadSection');
    toggleDisplay(requestAccountLeadSignatureChecked, 'accountLeadNameEmailSection', 'accountLeadSignatureFileUploadSection');
    

    //Binding the onclick events for the checkboxes.
    $('#requestOrgUnitHeadSignature').click(function(){
        var checked = $('#requestOrgUnitHeadSignature:checked').val()?true:false;
        toggleDisplay(checked, 'orgUnitHeadNameEmailSection', 'orgUnitHeadSignatureFileUploadSection');
    });

    $('#changeOrgUnitHeadSignature').click(function(){
        var checked = $('#changeOrgUnitHeadSignature:checked').val()?true:false;
        toggleDisplay(checked, 'orgunitsignature', 'orgUnitHeadSignature');
    });

    $('#requestAccountLeadSignature').click(function(){
        var checked = $('#requestAccountLeadSignature:checked').val()?true:false;
        toggleDisplay(checked, 'accountLeadNameEmailSection', 'accountLeadSignatureFileUploadSection');
    });

    $('#changeAccountLeadSignature').click(function(){
        var checked = $('#changeAccountLeadSignature:checked').val()?true:false;
        toggleDisplay(checked, 'accountsignature', 'accountLeadSignature');
    });
	
     
    $('#orgUnitHeadDesig').val(<?php echo $accountDetails["orgunitdesignation"] ?>);
    $('#Accountdesignation').val(<?php echo $accountDetails["Accountdesignation"] ?>);
    
    $("#tabs").tabs();
});

function toggleDisplay(condition, controlToDisplayWhenTrue, controlToHideWhenTrue)
{
    if(condition)
    {
        $('#'+ controlToDisplayWhenTrue).show();
        $('#'+ controlToHideWhenTrue).hide();
    }
    else
    {
        $('#'+ controlToDisplayWhenTrue).hide();
        $('#'+ controlToHideWhenTrue).show();
    }
}
function changeLogo(){
	var display3 = document.getElementById("displayLogo");
	var upload3= document.getElementById("uploadLogo");
	var hidden3 = document.getElementById("logo");
	var button = document.getElementById("change3");
	if(hidden3.value == 0){
		hidden3.value = 1;
		display3.style.display='none';
		upload3.style.display='';
		button.value = "Do not Change";
	}
	else if(hidden3.value == 1){
		hidden3.value = 0;
		display3.style.display='';
		upload3.style.display='none';
		button.value = "Change";
	}
}
function ConfirmInActive(){
	if (document.getElementById("IsActive").checked==false) {
		if (confirm('Are you sure to wish to make the Account inactive ?'))
		{
			document.getElementById("IsActive").checked=false;
		}
		else {
			document.getElementById("IsActive").checked=true;
		}
	}
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
	if ($dataKey=='accountDetails'){
		$accountDetails=$dataValue;
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
$form->openForm(array('action' => '?load=account/editAccount/'.$accountDetails['id'], 'name' => 'editAccountForm', 'id' => 'editAccountForm'));

$form->openTable();
$form->openTableRow();
$form->openTableColumn(array('valign'=>'top'));

$form->openTable();
/** Account Name textbox  **/
$form->openTableRow();
$form->openTableColumn();
$form->addLabel('Account Name <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Name ','style' => 'width:10em ;text-align:left'));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->addInput('text', array('name' => 'accountname','value' => $accountDetails['accountname'],'style' => 'width: 15em', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->closeTableColumn();
$form->closeTableRow();


/** "Account Acronym" textbox  **/       
$form->openTableRow();
$form->openTableColumn(array());   
$form->addLabel('Account Acronym <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Acronym: ','style' => 'width:10em '));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->addInput('text', array('name' => 'accountshortname','value' => $accountDetails['accountshortname'],'style' => 'width:10em', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->closeTableColumn();
$form->closeTableRow(); 

/** Account Description text area  **/  
$form->openTableRow();
$form->openTableColumn(array());   
$form->addLabel('Account Description <font color="red">&nbsp;*</font>', array('for' => 'Account Description:','style' => 'width:11em '));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->addTextarea($accountDetails['accountdescription'], array('name' => 'accountdescription','style' => 'width: 15em; height:5em', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->closeTableColumn();
$form->closeTableRow(); 
 

/** Region Dropdown **/       
$form->openTableRow();
$form->openTableColumn(array());   
$form->addLabel('Region <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Region: ','style' => 'width:10em'));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->openSelect(array('name'=>'regionid','style' => 'width:15em ', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select a Region',array('value'=>''));
foreach($regioncombo as $key=>$val ){
	if($key==$accountDetails['regionid']){
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
$form->openTableColumn(array()); 
$form->addLabel('Vertical <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Vertical: ','style' => 'width:10em'));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->openSelect(array('name'=>'accountverticalid','style' => 'width:15em ', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select a vertical',array('value'=>''));
foreach($verticalcombo as $key=>$val ){
	if($key==$accountDetails['accountverticalid']){
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
$form->openTableColumn(array()); 
$form->addLabel('Primary Engagement Scope <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Primary Engagement Scope:','style' => 'width:10em '));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->openSelect(array('name'=>'primaryengagmentscope','style' => 'width:15em ', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select scope',array('value'=>''));
foreach($scopecombo as $key=>$val ){
	if($key==$accountDetails['primaryengagmentscope']){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
}
$form->closeSelect();
$form->closeTableColumn();
$form->closeTableRow();

$form->closeTable(); 
$form->closeTableColumn();
$form->openTableColumn(array('valign'=>'top','style'=>'padding-left:20px;'));


$form->openTable();

/** Account Status **/
$form->openTableRow();
$form->openTableColumn(array());
$form->addLabel('Account Status <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Account Status:','style' => 'width:20em '));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->openSelect(array('name'=>'accountstatusid','style' => 'width:15em ', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select status',array('value'=>''));
foreach($statuscombo as $key=>$val ){
	if($key==$accountDetails['accountstatusid']){
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
$form->openTableColumn(array());
$form->addlabel('Already Supported by CSC India? <font color="red">&nbsp;&nbsp;*</font>',array('for'=>'Already Supported by CSC India?','style' => 'width:20em '));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
if (!empty($accountDetails['supportedinindia'])){
     if ($accountDetails['supportedinindia']==1){
     	$form->addInput('radio', array('name'=>'supportedinindia','value'=>'Yes','checked'=>'checked','style' => 'width: 1em;'));
        $form->addInline('&nbsp;&nbsp; Yes &nbsp;&nbsp;&nbsp;&nbsp;');  
        $form->addInput('radio', array('name'=>'supportedinindia','value'=>'No','style' => 'width: 1em;'));
        $form->addInline('&nbsp;&nbsp; No');
	}
    else if ($accountDetails['supportedinindia']==0){
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


/* is Active checkbox */
$form->openTableRow();
$form->openTableColumn(array());
$form->addLabel('Is Active <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Is Active','style' => 'width:20em '));  
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->addInput('checkbox', array('name' => 'isActive', 'id' => 'isActive','checked'=>'checked','style' => 'width: 1em; height:1em','onClick'=>'ConfirmInActive()')); 
$form->closeTableColumn();
$form->closeTableRow();

/****Designation and signatures..****/

/** Account Executive **/

$form->openTableRow();
$form->openTableColumn(array());
$form->addLabel('Account Exec.(For Region incase of Global account) <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Exec.(For Region incase of Global account)','style' => 'width:20em'));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->addInput('text', array('name' => 'Accountexecutiveglobalid','value' => $accountDetails['Accountexecutiveglobalid'],'style' => 'width:10em ', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser1" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->closeTableColumn();
$form->closeTableRow();


/** Account Lead in India **/

$form->openTableRow();
$form->openTableColumn(array());
$form->addLabel('Account Lead in India <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Lead in India','style' => 'width:20em '));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->addInput('text', array('name' => 'accountleadinindia','value' => $accountDetails['accountleadinindia'],'style' => 'width:10em ', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser2" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->closeTableColumn();
$form->closeTableRow();

/**LSC Team Admin Representative */
$form->openTableRow();
$form->openTableColumn(array());
$form->addLabel('LSC Admin Representative <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'LSC Admin Representative','style' => 'width:20em '));
$form->closeTableColumn();
$form->openTableColumn(array('style'=>'text-align:left;padding-left:10px;'));
$form->addInput('text', array('name' => 'LSCadmin','value' => $accountDetails['LSCadmin'],'style' => 'width:10em ', 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser3" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->closeTableColumn();
$form->closeTableRow();
$form->closeTable();
$form->closeTableColumn();

//Signature Part
$form->openTableColumn(array('valign'=>'top','style'=>'padding-left:20px;'));
// Create the Tab layout and Render
$tabsHtml = '<div id="tabs" style=" float:left; margin-left: 10px;"><ul><li><a href="#tabs-1">Level 1 Head</a></li><li><a href="#tabs-2">Level 2 Head</a></li><li><a href="#tabs-3">Account Logo</a></li></ul><div id="tabs-1" >';
$form->addInline($tabsHtml);

/** Org unit head designation  **/
$form->addInline('<div id="orgUnitHeadDesig",style="font: bold 15px arial,sans-serif">');
$form->addLabel('Select designation <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Select designation:','style' => 'width:10em '));   
$form->openSelect(array('name'=>'orgunitdesignation','width'=>'200px','onchange'=>'getOrgDesignation(this.value)', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select Org Unit Head Designation',array('value'=>''));
foreach($orgDesigcombo as $key=>$val ){
	if($key==$accountDetails['orgunitdesignation']){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
}
$form->closeSelect();
$form->addInline('</div>');
if(!empty ($accountDetails['orgunitdesignation'])){
	$label=$orgDesigcombo[$accountDetails['orgunitdesignation']];
}
else { $label = "Org Unit Head"; }
$form->addInline('<div id="orgUnitHeadSignatureFileUploadSection">');
$form->addLabel('Signature <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Upload Signature','style' => 'width:10em '));
if (!empty($accountDetails['orgunitsignature'])){
	$form->addInline(sprintf("<img id='orgUnitHeadSignature' width='150px' height='40px' style='border: #000000 solid thin;' src='data:image/jpeg;base64,%s' />", base64_encode($accountDetails["orgunitsignature"])).'&nbsp;&nbsp');
}
$form->addInput('file', array('name'=>'orgunitsignature','id'=>'orgunitsignature'));
$form->addInline('</div><div id="orgUnitHeadNameEmailSection">');
$form->addLabel($label.' <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Org Unit Head','style' => 'width:10em '));
$form->addInput('text', array('name' => 'orgunithead','value' => $accountDetails['orgunithead'], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser4" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->addInline('<br/>');
$form->addlabel('',array('for'=>'','style' => 'width:10em '));
$form->addInput('button', array('name'=>'mailLink_org','value'=>'Send link'));
$form->addInline('</div>');
if (!empty($accountDetails['orgunitsignature'])){
	$form->addLabel($lang['change_sign'], array('for' => 'changeOrgUnitHeadSignature','style' => 'width:10em '));
	$form->addInput('checkbox', array('name' => 'changeOrgUnitHeadSignature', 'id' => 'changeOrgUnitHeadSignature', 'value' => 'true', $accountDetails['ChangeOrgUnitHeadSignature'] => $accountDetails['ChangeOrgUnitHeadSignature']));
}
$form->addInline('<br/>');
$form->addLabel($lang['request_new_signature'], array('for' => 'requestOrgUnitHeadSignature','style' => 'width:10em '));
$form->addInput('checkbox', array('name' => 'requestOrgUnitHeadSignature', 'id' => 'requestOrgUnitHeadSignature', 'value' => 'true', $accountDetails['requestOrgUnitHeadSignature'] => $accountDetails['requestOrgUnitHeadSignature']));
$form->addInline('</div><div id="tabs-2"  >');
           


/*Signature 2 */



/** Account lead designation & sign **/
$form->addInline('<div id="Accountdesignation",style="font: bold 15px arial,sans-serif">');
$form->addLabel('Select designation <font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Select designation','style' => 'width:10em '));   
$form->openSelect(array('name'=>'Accountdesignation','width'=>'200px','onchange'=>'getLeadDesignation(this.value)', 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select Account Lead Designation',array('value'=>''));
foreach($leadDesigcombo as $key=>$val ){
	if($key==$accountDetails['Accountdesignation']){
		$form->addOption($val,array('value'=>$key,'selected'=>'selected'));
    }  
    else{
        $form->addOption($val,array('value'=>$key));
    }
}
$form->closeSelect();
$form->addInline('</div>');
if(!empty ($accountDetails['Accountdesignation'])){
	$label=$leadDesigcombo[$accountDetails['Accountdesignation']];
}
else { $label = 'Account Lead'; }
$form->addInline('<div id="accountLeadSignatureFileUploadSection">');
$form->addLabel('Signature <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Upload Signature','style' => 'width:10em '));
if (!empty($accountDetails['accountsignature'])){
	$form->addInline(sprintf("<img id='accountLeadSignature' width='150px' height='40px' style='border: #000000 solid thin;' src='data:image/jpeg;base64,%s' />", base64_encode($accountDetails["accountsignature"])).'&nbsp;&nbsp');
}
$form->addInput('file', array('name'=>'accountsignature','id'=>'accountsignature'));
$form->addInline('</div><div id="accountLeadNameEmailSection">');
$form->addLabel($label. '<font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Lead','style' => 'width:10em '));
$form->addInput('text', array('name' => 'accountleadid','value' => $accountDetails['accountleadid'], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('&nbsp;&nbsp;');
$form->addInline(sprintf('<a id="searchUser5" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" style="padding-bottom:3px" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']));
$form->addInline('<br/>');
$form->addlabel('',array('for'=>'','style' => 'width:10em '));
$form->addInput('button', array('name'=>'mailLink_org','value'=>'Send link'));
$form->addInline('</div>');
if (!empty($accountDetails['accountsignature'])){
	$form->addLabel($lang['change_sign'], array('for' => 'changeAccountLeadSignature','style' => 'width:10em '));
	$form->addInput('checkbox', array('name' => 'changeAccountLeadSignature', 'id' => 'changeAccountLeadSignature', 'value' => 'true', $accountDetails['changeAccountLeadSignature'] => $accountDetails['changeAccountLeadSignature']));
}
$form->addInline('<br/>');
$form->addLabel($lang['request_new_signature'], array('for' => 'requestAccountLeadSignature','style' => 'width:10em '));
$form->addInput('checkbox', array('name' => 'requestAccountLeadSignature', 'id' => 'requestAccountLeadSignature', 'value' => 'true', $accountDetails['requestAccountLeadSignature'] => $accountDetails['requestAccountLeadSignature']));
$form->addInline('</div><div id="tabs-3">');


/** Account Logo Image File 
**/


$form->addInline('<div id="displayLogo">');
$form->addLabel('Account Logo <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Logo','style' => 'width:10em '));
$form->addInline(sprintf("<img id='accountLogo' width='150px' height='40px' style='border: #000000 solid thin;' src='data:image/jpeg;base64,%s' />", base64_encode($accountDetails["accountlogo"])));
$form->addInline('</div><div id="uploadLogo" style="display:none">');
$form->addLabel('Upload Account Logo <font color="red">&nbsp;&nbsp;*</font>', array('for' => 'Account Logo','style' => 'width:10em '));
$form->addInput('file', array('name'=>'accountlogo'));
$form->addInline('</div>');
$form->addlabel('',array('for'=>'','style' => 'width:10em '));
$form->addInput('button', array('name'=>'ChangeLogo','value'=>'Change','id'=>'change3','onclick'=>'changeLogo()'));
$form->addInput('hidden', array('name'=>'logo','value'=>0,'id'=>'logo'));
$form->addInline('</div></div>');

$form->closeTableColumn();
$form->closeTableRow();
$form->closeTable(); 
/** Submit button  **/  
	
$form->addInline('<p align=right style="padding-right:30px">');
$form->addInput('submit', array('name' => 'submit', 'value' => 'Save Changes'));
$form->addInline('&nbsp;&nbsp;');
$form->addInput('submit', array('name' => 'cancel', 'value' => 'Cancel'));
$form->addInline('</p>');             
$form->closeForm();  
            
$form->closeForm();            
echo $form;

//Error messages

$errorMessage='';
if (!empty($message)) {
    	$errorMessage = implode($message, '\n');
    
}

if(count($message) > 0)
{
    echo '<script type="text/javascript"> $(document).ready(function(){ alert("Please correct the following errors: \n\n'.$errorMessage.'"); });</script>';
}

?>

