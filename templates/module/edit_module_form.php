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
// @Created by Rajendra N Mohanty                                                      //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////

//ob_start();
//TO DO
include_once __SITE_PATH . '/lang/lang.php';
require_once __SITE_PATH . '/libs/form_handler.php';

?>
<script type="text/javascript">

function ConfirmInActive(){
	if (document.getElementById("IsActiveID").checked==false) {
		if (confirm('Are you sure to wish to make the module inactive ?'))
		{
			document.getElementById("IsActiveID").checked=false;
		}
		else {
			document.getElementById("IsActiveID").checked=true;
		}
	}
}
function ValidateTraining(event){
	return ( event.ctrlKey || event.altKey 
            || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
            || (95<event.keyCode && event.keyCode<106)
            || (event.keyCode==8) || (event.keyCode==9)
            || (event.keyCode>34 && event.keyCode<40) 
            || (event.keyCode==46) )
}
function Display(alertMsg){
	alert(alertMsg);
	return;
}
</script>
<?php
	//Retreiving the Knowledge Node, Account and messgae from server side
	foreach($data as $key=>$val ){
		if($key=='knowledge'){
           $knode=$val;
        }
        if($key=='account'){
           $account=$val;
        }
		if($key=='message'){
           $message=$val;
        }
	}
	foreach ($data as $key => $values) {
	    if ($key == 'details') {
	    	foreach ($values as $key1 => $value1) {
	    		$id=$value1['id'];
	    		$knodeVal=$value1['k_node'];
	    		$accountID=$value1['account_id'];
	            $Modulename=$value1['module_name'];
	            $Trainingminutes=$value1['training_minutes'];
	            $IsConfidential=$value1['is_confidential'];
	        	$Threshold=$value1['module_threshold'];
	            $Isactive=$value1['is_active'];
	        }
	    }
	}
	$param = "$id,$knodeVal,$accountID";
	//
	$accountText='';
    $knodeText='';
    if ($knodeVal!=''){
		foreach($knode as $key=>$val ){
            if ($knodeVal==$val['meta_code']) {
            	$knodeText=$val['meta_text'];
            }
        }
        foreach($account as $key=>$val ){
            if ($accountID==$val['id']) {
            	$accountText=$val['account_name'];
        	}
        }
    }
    //Displaying the Knowledge Node and Account description on the top of the form 
    if ($knodeText!='') {
		$form1 = new lscform();
		$form1->openForm(array('action' => '*', 'name' => 'viewHeaderInfo'));
		$textH='<div style="color: green;font: bold 12px arial,sans-serif;"><b>'.$knodeText.'</b>';
		if ($accountText!='') {
			$textH.='<b> : </b>';
			$textH.='<b>'.$accountText.'</b>';
		}
		$textH.='</div>';
		$form1->addInline(''.$textH.'');
		$form1->addInline('<br />');
		$form1->closeForm();
		echo $form1;
	}
	//Form to accept 
	$form = new lscform();
	$form->openForm(array('action' => '?load=module/updateModuleDetails/'.$param.'', 'name' => 'editModuleForm'));
	$form->addLabel('Module Name <font color="red">*</font>',array('text-align'=>'right','style'=>'width:120px;'));
	$form->addInput("hidden",array('name'=>'moduleName','id'=>'moduleNameID','value'=>$Modulename,'style'=>'width:300px;"'));
	$form->addInput("text",array('name'=>'moduleName','id'=>'moduleNameID','value'=>$Modulename,'disabled'=>'true'));
	$form->addInline('<br />');
	$form->addLabel('Training Minutes <font color="red">*</font>',array('text-align'=>'right','style'=>'width:120px;'));
	$form->addInput("text",array('name'=>'trainingMinutes','maxlength'=>'3','value'=>$Trainingminutes,'style'=>'width:75px','onkeydown'=>'return ValidateTraining(event);'));
	$form->addInline('<br />');
	$form->addLabel('Is Confidential?',array('text-align'=>'right','style'=>'width:120px;'));
	if ($IsConfidential==1){
		$confidential='ture';
		$form->addInput("checkbox",array('name'=>'IsConfidential','style' => 'width: 1em; height:1em','checked'=>$confidential));
	}
	else {
		$form->addInput("checkbox",array('name'=>'IsConfidential','style' => 'width: 1em; height:1em'));
	}
	$form->addInline('<br />');
	$form->addLabel('Threshold <font color="red">*</font>',array('text-align'=>'right','style'=>'width:120px;'));
	$form->openSelect(array('name'=>'threshold','width'=>'100px'));
	foreach ($data as $key => $values) {
	    if ($key == 'threshold') {
	        foreach ($values as $key1 => $value2) {
	            $thresholdMin=$value2['meta_text'];
	            $optVal=$value2['meta_code'];
	            if ($Threshold==$optVal){
					$form->addOption($thresholdMin,array('value'=>$optVal,'style'=>'font: bold 12px arial,sans-serif','style' => 'width: 1em; height:1em','selected'=>'selected'));
	            }
	            else {
	            	$form->addOption($thresholdMin,array('value'=>$optVal,'style'=>'font: bold 12px arial,sans-serif'));
	            }
	        }
	    }
	}
	$form->closeSelect();
	$form->addInline('<br />');
	$form->addLabel('Is Active?',array('text-align'=>'right','style'=>'width:120px;'));
	if ($Isactive==1){
		$cheked='ture';
		$form->addInput("checkbox",array('name'=>'IsActive','id'=>'IsActiveID','style' => 'width: 1em; height:1em','checked'=>$cheked,'onClick'=>'ConfirmInActive()'));
	}
	else {
		$form->addInput("checkbox",array('name'=>'IsActive','id'=>'IsActiveID','style' => 'width: 1em; height:1em','onClick'=>'ConfirmInActive()'));
	}
	$form->addInline('<br /><p align="left">');
	for ($i=0;$i<50;$i++){
		$form->addInline('&nbsp');	
	}
	$form->addButton('submit', array('name' => 'submit', 'value' => 'Save'));
	$form->addInline('&nbsp;');
	$form->addInput('submit', array('name' => 'cancel', 'value' => 'Cancel'));
	$form->addInline('</p>');
	$form->closeForm();
	echo $form;
	//Error messages
	$alertMessage='';
	if (!empty($message)) {
		foreach ($message as $value) {
	    	$alertMessage.=$value.'\n';
	    }
	}
	if ($alertMessage!='') {
		$alertMessage='"'.$alertMessage.'"';
		echo '<script type="text/javascript">Display('.$alertMessage.');</script>';
	}
?>          
