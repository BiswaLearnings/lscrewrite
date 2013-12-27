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
function AddRow() {
	var missing='';
	var tableID="ListPromptHeader";
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for (cntr=0;cntr<rowCount;cntr++){
		var TrainingMinText="";
		var TrainingMinfield="";
		var moduleNameText="";
		var ModuleNamefield="";
		//
		var moduleNameText=table.rows[cntr].cells[1].innerHTML;
		var ModuleNamefield=moduleNameText.search("value=");
		var TrainingMinText=table.rows[cntr].cells[2].innerHTML;
		var TrainingMinfield=TrainingMinText.search("value=");
		//
		var rownum=cntr+1;
		if (ModuleNamefield == -1) missing=missing+'\nModule Name'+' on row '+ rownum;
		if (TrainingMinfield == -1)  missing=missing+'\nTraining Minutes'+' on row '+rownum;
		//
	}
	if (missing=='') {
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			switch(newcell.childNodes[0].type) { 
				case "text":
					newcell.childNodes[0].value = "";
					break;                                      
				case "select-one":
					newcell.childNodes[0].selectedIndex = 0;
					break;                 
			}             
		} 
	}
	else
	{
		alert('The following columns are mandatory and must be entered : \n'+missing);
	}       
} 
function DeleteRow() {
	var tableID="ListPromptHeader";
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		if(rowCount <= 1) {
			alert("Cannot delete all the rows.");
			var chkbox = table.rows[0].cells[0].childNodes[0];
			chkbox.checked=false;
			return;
		}
		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];                 
			var chkbox = row.cells[0].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						chkbox.checked=false;
						return;
					}
					table.deleteRow(i);                     
					rowCount--;                     
					i--;                 
			}                 
		} 
	}
	catch(e) { 
		alert(e);
	}
}
function ValidateModuleName(event){
	return ( event.ctrlKey || event.altKey 
            || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)
            || (64<event.keyCode && event.keyCode<91) 
            || (96<event.keyCode && event.keyCode<124)
            || (95<event.keyCode && event.keyCode<106)
            || (event.keyCode==8) || (event.keyCode==9)|| (event.keyCode==32)
            || (event.keyCode>34 && event.keyCode<40) 
            || (event.keyCode==46) )
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
	$addDetails=array();
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
		if($key=='AddDetails'){
        	$addDetails=$val;
        }
		if($key=='threshold'){
        	$threshold=$val;
        }
	}
	
	$knodeVal=$data['BASE'][0];
	$accountid=$data['BASE'][1];
	$basicDetails="$knodeVal,$accountid";
	$form = new lscform();
	$form->openForm(array('action' => '?load=module/AddModuleDetails/'.$basicDetails.'', 'name' => 'addModuleForm'));
	$form->addInline('<div style="color: green;font: bold 12px arial,sans-serif;">');
	$accountText='';
    $knodeText='';
    if ($knodeVal!=''){
		foreach($knode as $key=>$val ){
            if ($knodeVal==$val['meta_code']) {
            	$knodeText=$val['meta_text'];
            }
        }
        foreach($account as $key=>$val ){
            if ($accountid==$val['id']) {
            	$accountText=$val['account_name'];
        	}
        }
    }
    if ($knodeText!='') {
		$textH='<b>'.$knodeText.'</b>';
	    if ($accountText!='') {
	    	$textH.='<b> : </b>';
	    	$textH.='<b>'.$accountText.'</b>';
	    }
	}
	$form->openTable(array('name' => 'add_module_Button_table', 'id'=>'buttontable','cellpadding' => "0", 'cellspacing' => "10", 'border' => "0",'width'=>'100%'));
	$form->openTableBody();
	$form->openTableRow(array());
	if ($textH!='') {
		$form->openTableColumn(array('width'=>'80%'));
		$form->addInline('<p>'.$textH.'</p>');
		$form->closeTableColumn();
	}
	$form->openTableColumn(array('width'=>'20%'));
	$form->addInput('button', array('name' => 'addRow', 'value' => 'Add a Row', 'style' => 'height:20px;width:90px;font: bold 10px arial,sans-serif;','onclick'=>'AddRow()'));
	$form->addInline('&nbsp;');
	$form->addInput('button', array('name' => 'deleteRow', 'value' => 'Delete a Row', 'style' => 'height:20px;width:90px;font: bold 10px arial,sans-serif;','onclick'=>'DeleteRow()'));
	$form->closeTableColumn();
	$form->closeTableBody();
	$form->closeTable();
	$form->addInline('</div>');
	//New Table : Start
	$form->addInline('<div id="InputTableHead" style="position:relative; left:75px; top:0px; width:85%; height:20px;z-index:2; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 0px; border-left-width: 1px">');
	$form->openTable(array('name' => 'add_module_table_header', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0",'width'=>'100%'));
	$form->openTableHeader();
	$form->openTableRow(array('style'=>'background:#D3D3D3;color:black;font:bold 12px arial,sans-serif;border-style:outset;border-color:#0066A2;height:20px;width:80px;font: bold 15px arial,sans-serif, float: left;'));
	$form->addTableHead("Delete",array('width'=>'3%','style'=>'font:bold 12px arial,sans-serif;text-align:center;'));
	$form->addTableHead($lang[modulename],array('width'=>'30%','style'=>'font:bold 12px arial,sans-serif;text-align:center;'));
	$form->addTableHead($lang[trainingminutes],array('width'=>'16%','style'=>'font:bold 12px arial,sans-serif;text-align:center;'));
	$form->addTableHead($lang[isconfidential],array('width'=>'15%','style'=>'font:bold 12px arial,sans-serif;text-align:center;'));
	$form->addTableHead($lang[threshold],array('width'=>'15%','style'=>'font:bold 12px arial,sans-serif;text-align:center;'));
	$form->addTableHead($lang[isactive],array('width'=>'15%','style'=>'font:bold 12px arial,sans-serif;text-align:center;'));
	$form->closeTableRow();
	$form->closeTableHeader();
	$form->closeTable();
	$form->addInline('</div>');
	$form->addInline('<div class="mcright" id="InputTableBody" style="position:relative; left:75px; top:0px; width:87%; height:250px; z-index:2; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;overflow-y:auto">');
	$form->openTable(array('name' => 'add_module_table_details', 'id'=>'ListPromptHeader','cellpadding' => "0", 'cellspacing' => "10", 'border' => "0",'width'=>'100%'));
	$form->openTableBody();
	if ($addDetails) {
		foreach($addDetails as $key=>$val){
			$form->openTableRow(array());
			$form->openTableColumn(array('width'=>'2%'));
			$form->addInput("checkbox",array('name'=>'chk','style' => 'width: 1em; height:1em' ));
			$form->closeTableColumn();
			$form->openTableColumn(array('width'=>'30%'));
			$form->addInput("text",array('name'=>'moduleName[]','id'=>'moduleNameID','style'=>'width:350px;','value'=> $val[0],'onkeydown'=>'return ValidateModuleName(event);'));
			$form->closeTableColumn();
			$form->openTableColumn(array('width'=>'10%'));
			$form->addInput("text",array('name'=>'trainingMin[]','id'=>'trainingMin','style'=>'width:150px;','value'=>$val[1],'onkeydown'=>'return ValidateTraining(event)'));
			$form->closeTableColumn();
			$form->openTableColumn(array('width'=>'16%'));
			$form->addInline('<div align="center">');
			if ($val[2]=1){
				$form->addInput("checkbox",array('name'=>'isConfidential[]','checked'=>'checked','style' => 'width: 1em; height:1em' ));
			}
			if ($val[2]=0){
				$form->addInput("checkbox",array('name'=>'isConfidential[]','style' => 'width: 1em; height:1em' ));
			}
			$form->addInline('</div>');
			$form->closeTableColumn();
			$form->openTableColumn(array('width'=>'15%'));
			$form->addInline('<div align="center">');
			$form->openSelect(array('name' => 'threshold[]','style'=>'width:100px'));
			foreach ($data as $key => $values) {
				if ($key == 'threshold') {
					foreach ($values as $key1 => $value2) {
						$thresholdMin=$value2['meta_text'];
						$optVal=$value2['meta_code'];
						if ($val[3]==$optVal){
							$form->addOption($thresholdMin, array('value' => $optVal,'selected'=>'selected'));
						}
						else {
							$form->addOption($thresholdMin, array('value' => $optVal));
						}
					}
				}
			}
			$form->closeSelect();
			$form->addInline('</div>');
			$form->closeTableColumn();
			$form->openTableColumn(array('width'=>'15%'));
			$form->addInline('<div align="center">');
			if ($val[2]=1){
				$form->addInput("checkbox",array('name'=>'isActive[]','checked'=>'checked','style' => 'width: 1em; height:1em' ));
			}
			if ($val[2]=0){
				$form->addInput("checkbox",array('name'=>'isActive[]','style' => 'width: 1em; height:1em' ));
			}
			$form->addInline('</div>');
			$form->closeTableColumn();
		}	
	}
	else {
		$form->openTableRow();
		$form->openTableColumn(array('width'=>'2%'));
		$form->addInput("checkbox",array('name'=>'chk','style' => 'width: 1em; height:1em'));
		$form->closeTableColumn();
		$form->openTableColumn(array('width'=>'30%'));
		$form->addInput("text",array('name'=>'moduleName[]','id'=>'moduleNameID','value'=>'','style'=>'width:350px;','size'=>'175','maxlength'=>'50','onkeydown'=>'return ValidateModuleName(event);'));
		$form->closeTableColumn();
		
		$form->openTableColumn(array('width'=>'10%'));
		$form->addInput("text",array('name'=>'trainingMin[]','value'=>'','style'=>'width:150px','size'=>'15','maxlength'=>'3','onkeydown'=>'return ValidateTraining(event);'));
		$form->closeTableColumn();
		
		$form->openTableColumn(array('width'=>'16%'));
		$form->addInline('<div align="center">');
		$form->addInput("checkbox",array('name'=>'isConfidential[]','checked'=>'checked','style' => 'width: 1em; height:1em'));
		$form->addInline('</div>');
		$form->closeTableColumn();
			
		$form->openTableColumn(array('width'=>'15%'));
		$form->addInline('<div align="center">');
		$form->openSelect(array('name' => 'threshold[]'));
		foreach ($data as $key => $values) {
			if ($key == 'threshold') {
				foreach ($values as $key1 => $value2) {
					$thresholdMin=$value2['meta_text'];
					$optVal=$value2['meta_code'];
					$form->addOption($thresholdMin, array('value' => $optVal));
				}
			}
		}
		$form->closeSelect();
		$form->addInline('</div>');
		$form->closeTableColumn();
		
		$form->openTableColumn(array('width'=>'15%'));
		$form->addInline('<div align="center">');
		$form->addInput("checkbox",array('name'=>'isActive[]','checked'=>'checked','style' => 'width: 1em; height:1em' ));
		$form->addInline('</div>');
		$form->closeTableColumn();
	}
	$form->closeTableRow();
	$form->closeTableBody();
	$form->closeTable();
	$form->addInline('</div>');
	$form->addInline('<p align="center">');
	$form->addInput('submit', array('name' => 'submit', 'value' => 'Save'));
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
	//New Table : End     
?>


