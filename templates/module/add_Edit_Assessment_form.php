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
// @date 2013-4-4                                                      	   			//
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

function SelectShuffleQY(){
	ShuffleQYes=document.getElementById("ShuffleQYes").checked;
	if(ShuffleQYes){
		document.getElementById("ShuffleQYes").checked=true;
		document.getElementById("ShuffleQNo").checked=false;
	}
}
function SelectShuffleQN(){
	ShuffleQNo=document.getElementById("ShuffleQNo").checked;
	if(ShuffleQNo){
		document.getElementById("ShuffleQNo").checked=true;
		document.getElementById("ShuffleQYes").checked=false;
	}
}
function SelectShuffleWQY(){
	ShuffleWQYes=document.getElementById("ShuffleWQYes").checked;
	if(ShuffleWQYes){
		document.getElementById("ShuffleWQYes").checked=true;
		document.getElementById("ShuffleWQNo").checked=false;
	}
}
function SelectShuffleWQN(){
	ShuffleWQNo=document.getElementById("ShuffleWQNo").checked;
	if(ShuffleWQNo){
		document.getElementById("ShuffleWQNo").checked=true;
		document.getElementById("ShuffleWQYes").checked=false;
	}
}

function ConfirmInActive(){
	if (document.getElementById("IsActiveID").checked==false) {
		if (confirm('Are you sure to wish to make the Assessment inactive ?'))
		{
			document.getElementById("IsActiveID").checked=false;
		}
		else {
			document.getElementById("IsActiveID").checked=true;
		}
	}
}
function ValidateTimeLimit(event){
	return ( event.ctrlKey || event.altKey 
            || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
            || (95<event.keyCode && event.keyCode<106)
            || (event.keyCode==8) || (event.keyCode==9)
            || (event.keyCode>34 && event.keyCode<40) 
            || (event.keyCode==46) )
}
function ValidateInput(control){
		
	stat1Value=parseInt(document.getElementById('status1').value);
	stat2Value=parseInt(document.getElementById('status2').value);
	stat3Value=parseInt(document.getElementById('status3').value);
	stat4Value=parseInt(document.getElementById('status4').value);
	stat5Value=parseInt(document.getElementById('status5').value);
	grade1Value=parseInt(document.getElementById('gradeBoundary1').value);
	grade2Value=parseInt(document.getElementById('gradeBoundary2').value);
	grade3Value=(document.getElementById('gradeBoundary3').value);
	grade4Value=(document.getElementById('gradeBoundary4').value);
	grade5Value=(document.getElementById('gradeBoundary5').value);
	
	if(control.name=='status1'){
		
		if (stat1Value==1000) {
			document.getElementById('gradeBoundary1').value=-1;
			return;
		}
		else {
			if (stat1Value>stat2Value || stat1Value>stat3Value || stat1Value>stat4Value || stat1Value>stat5Value){
				alert("Status 1 feedback code can not be less than other status's feedback code");
				document.getElementById('status1').value=stat1Value;
				
			}
			if (stat1Value==stat2Value || stat1Value==stat3Value || stat1Value==stat4Value || stat1Value==stat5Value){
				alert("Status 1 feedback code can not be equal with other status's feedback code");
				document.getElementById('status1').value=stat1Value;
				
			}
		}
	}
	if(control.name=='status2'){
		if (stat2Value==1000) {
			document.getElementById('gradeBoundary2').value=-1;
			return;
		}
		else {
			if (stat2Value>stat3Value || stat2Value>stat4Value || stat2Value>stat5Value){
				alert("Status 2 feedback code can not be less than below status's feedback code");
				document.getElementById('status2').value=stat2Value;
				
			}
			if (stat2Value<stat1Value){
				alert("Status 2 feedback code can not be greater than above status's feedback code");
				document.getElementById('status2').value=stat2Value;
				
			}
			if (stat2Value==stat1Value || stat2Value==stat3Value || stat2Value==stat4Value || stat2Value==stat5Value){
				alert("Status 2 feedback code can not be equal with other status's feedback code");
				document.getElementById('status2').value=stat2Value;
				
			}
		}
	}
	if(control.name=='status3'){
		if (stat3Value==1000) {
			document.getElementById('gradeBoundary3').value=-1;
			return;
		}
		else {
			if (stat3Value>stat4Value || stat3Value>stat5Value){
				alert("Status 3 feedback code can not be less than below status's feedback code");
				document.getElementById('status3').value=stat3Value;
				
			}
			if (stat3Value<stat1Value || stat3Value<stat2Value){
				alert("Status 3 feedback code can not be greater than above status's feedback code");
				document.getElementById('status3').value=stat3Value;
				
			}
			if (stat3Value==stat1Value || stat3Value==stat2Value || stat3Value==stat4Value || stat3Value==stat5Value){
				alert("Status 3 feedback code can not be equal with other status's feedback code");
				document.getElementById('status3').value=stat3Value;
				
			}
		}
	}
	if(control.name=='status4'){
		if (stat4Value==1000) {
			document.getElementById('gradeBoundary4').value=-1;
			return;
		}
		else {
			if (stat4Value>stat5Value){
				alert("Status 4 feedback code can not be less than below status's feedback code");
				document.getElementById('status4').value=stat4Value;
				
			}
			if (stat4Value<stat1Value || stat4Value<stat2Value || stat4Value<stat3Value){
				alert("Status 4 feedback code can not be greater than above status's feedback code");
				document.getElementById('status4').value=stat4Value;
				
			}
			if (stat4Value==stat1Value || stat4Value==stat2Value || stat4Value==stat3Value || stat4Value==stat5Value){
				alert("Status 4 feedback code can not be equal with other status's feedback code");
				document.getElementById('status4').value=stat4Value;
				
			}
		}
	}
	if(control.name=='status5'){
		if (stat5Value==1000) {
			document.getElementById('gradeBoundary5').value=-1;
			return;
		}
		if (stat5Value<stat2Value || stat5Value<stat3Value || stat5Value<stat4Value){
			alert("Status 5 feedback code can not be greater than above status's feedback code");
			document.getElementById('status5').value=stat5Value;
			
		}
		if (stat5Value==stat1Value ||stat5Value==stat2Value || stat5Value==stat3Value || stat5Value==stat4Value){
			alert("Status 5 feedback code can not be equal with above status's feedback code");
			document.getElementById('status5').value=stat5Value;
			
		}
	}
	if(control.name=='gradeBoundary1'){
		if (grade1Value==-1){
			document.getElementById('status1').value=1000;
		}
		else {
			if (grade1Value<grade2Value || grade1Value<grade3Value || grade1Value<grade4Value || grade1Value<grade5Value){
				alert("Grade Boundary can not be less than below Grade Boundaries");
				document.getElementById('gradeBoundary1').value=grade1Value;
				
			}
			if (grade1Value==grade2Value || grade1Value==grade3Value || grade1Value==grade4Value || grade1Value==grade5Value){
				alert("Grade Boundary can not be equal with below Grade Boundaries");
				document.getElementById('gradeBoundary1').value=grade1Value;
				
			}
		}
	}
	if(control.name=='gradeBoundary2'){
		if (grade2Value==-1){
			document.getElementById('status2').value=1000;
		}
		else {
			if (grade2Value<grade3Value || grade2Value<grade4Value || grade2Value<grade5Value){
				alert("Grade Boundary can not be less than below Grade Boundaries");
				document.getElementById('gradeBoundary2').value=grade2Value;
				
			}
			if (grade2Value>grade1Value){
				alert("Grade Boundary can not be greater than above Grade Boundaries");
				document.getElementById('gradeBoundary2').value=grade2Value;
				
			}
			if (grade2Value==grade1Value || grade2Value==grade3Value || grade2Value==grade4Value || grade2Value==grade5Value){
				alert("Grade Boundary can not be equal with other Grade Boundaries");
				document.getElementById('gradeBoundary2').value=grade2Value;
				
			}
		}
	}
	if(control.name=='gradeBoundary3'){
		if (grade3Value==-1){
			document.getElementById('status3').value=1000;
		}
		else {
			if (grade3Value<grade4Value || grade3Value<grade5Value){
				alert("Grade Boundary can not be less than below Grade Boundaries");
				document.getElementById('gradeBoundary3').value=grade3Value;
				
			}
			if (grade3Value>grade1Value || grade3Value>grade2Value){
				alert("Grade Boundary can not be greater than above Grade Boundaries");
				document.getElementById('gradeBoundary3').value=grade3Value;
				
			}
			if (grade3Value==grade1Value || grade3Value==grade2Value || grade3Value==grade4Value || grade3Value==grade5Value){
				alert("Grade Boundary can not be equal with other Grade Boundaries");
				document.getElementById('gradeBoundary3').value=grade3Value;
				
			}
		}
	}
	if(control.name=='gradeBoundary4'){
		if (grade4Value==-1){
			document.getElementById('status4').value=1000;
		}
		else {
			if (grade4Value<grade5Value){
				alert("Grade Boundary can not be less than below Grade Boundaries");
				document.getElementById('gradeBoundary4').value=grade4Value;
				
			}
			if (grade4Value>grade1Value || grade4Value>grade2Value || grade4Value>grade3Value){
				alert("Grade Boundary can not be greater than above Grade Boundaries");
				document.getElementById('gradeBoundary4').value=grade4Value;
				
			}
			if (grade4Value==grade1Value || grade4Value==grade2Value || grade4Value==grade3Value || grade4Value==grade5Value){
				alert("Grade Boundary can not be equal with other Grade Boundaries");
				document.getElementById('gradeBoundary4').value=grade4Value;
				
			}
		}
	}
	if(control.name=='gradeBoundary5'){
		if (grade5Value==-1){
			document.getElementById('status5').value=1000;
		}
		if (grade5Value>grade1Value || grade5Value>grade2Value || grade5Value>grade3Value || stat5Value>grade4Value){
			alert("Grade Boundary can not be greater than above Grade Boundaries");
			document.getElementById('gradeBoundary5').value=grade5Value;
			
		}
		if (grade5Value==grade1Value || grade5Value==grade2Value || grade5Value==grade3Value || stat5Value==grade4Value){
			alert("Grade Boundary can not be equal with above Grade Boundaries");
			document.getElementById('gradeBoundary5').value=grade5Value;
			
		}
	}

	if (stat1Value==1 || stat1Value==2 || stat1Value==3){
		document.getElementById("reqGrade").value=grade1Value;
	}
	if (stat2Value==1 || stat2Value==2 || stat2Value==3){
		document.getElementById("reqGrade").value=grade2Value;
	}
	if (stat3Value==1 || stat3Value==2 || stat3Value==3){
		document.getElementById("reqGrade").value=grade3Value;
	}
}
function Display(alertMsg){
	alert(alertMsg);
	return;
}
</script>
<?php
	$assessmentName='';
	$timeLimit='';
	$questionPerPage='';
	$ShuffleQ='';
	$ShuffleWithinQ='';
	$attemptsAllowed='';
	$gradingMethod='';
	$reqGrade='';
	$IsActive='';
	foreach($data as $key=>$val ){
		if($key=='message'){
           $message=$val;
        }
		if($key=='HeaderForAss'){
			$HeaderForAss=$val;
		}
		if($key=='quizDetails'){
			foreach($val as $field=>$value){
				$assessmentName = $value['quiz_name'];
	    		$timeLimit = $value['time_limit'];
	    		$questionPerPage = $value['question_perpage'];
	    		$ShuffleQ = $value['shuffle_questions'];
	    		$ShuffleWithinQ = $value['shuffle_within_questions'];
	    		$attemptsAllowed = $value['attempts_allowed'];
	    		$gradingMethod = $value['grading_methods'];
	    		$reqGrade = $value['required_grade'];
	    		$IsActive = $value['is_active'];
			}
		}
		$STAT=array();
		if($key=='feedbackDetails'){
			$i=0;
			foreach($val as $field=>$value){
				$feedbackCode=$value['feedback_code'];
				$maxGrade=$value['max_grade'];
				$STAT[$i][$feedbackCode]=$maxGrade;
				$i++;
			}
		}
	}
	
	$moduleID=$HeaderForAss[0];
	$moduleText=$HeaderForAss[1];
	
	$form = new lscform();
	$form->openForm(array('action' => '?load=module/AddUpdateAssessmentDetails/'.$moduleID.'', 'name' => 'addAssessmentForm'));
	if ($moduleText!='') {
		$form->addInline('<div style="color: green;font: bold 12px arial,sans-serif;padding-left:20px;"><b>'.$moduleText.'</b></div>');
	}
	$form->addInline('<div class="mcright" id="InputTableBody" style="position:relative; left:5%; top:15px; width:90%; height:320px; z-index:2; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;overflow-y:auto">');
	$form->openTable(array('name' => 'add_module_table_details', 'id'=>'ListPromptHeader','cellpadding' => "0", 'cellspacing' => "0", 'border' => "0",'width'=>'99%'));
	$form->openTableBody();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:10px;'));
	$form->addInline('<font color="green" text-align="right"><b>General</b></font>');
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:40px;'));
	$form->addInline('<font color="green" text-align="right"><b>Overall feedback</b></font>');
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addCustomLabel('Feedback Code',array('text-align'=>'left'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	$form->addCustomLabel('Grade Boundary',array('text-align'=>'left'));
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Assessment Name <font color="red"><strong>*</strong></font>',array('text-align'=>'left','style'=>'width:150px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addInput("text",array('name'=>'assessmentName','value'=>$assessmentName,'tabindex'=>'1','style'=>'width:200px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	$form->addLabel('Status 1',array('text-align'=>'left'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	if(!empty($STAT)){
		foreach($STAT[0] as $key2=>$value3){
			$stat=$key2;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'status1','id' => 'status1','tabindex'=>'11','style'=>'width:250px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => 1000));
	foreach ($data as $key => $values) {
		if ($key == 'status') {
			foreach ($values as $key1 => $value2) {
				$statusText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==1)){
					$form->addOption($statusText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					if ($optVal!=0) $form->addOption($statusText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	if(!empty($STAT)){
		foreach($STAT[0] as $key2=>$value3){
			$stat=$value3;
		}
	}
	else {
		$stat='';
	}
	$form->addInput("hidden",array('name'=>'gradeBoundary1','value'=>100,'style'=>'width:300px;"'));
	$form->openSelect(array('name' => 'gradeBoundary1','id' => 'gradeBoundary1','tabindex'=>'12','style'=>'width:100px','disabled'=>'disbaled','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => -1));
	foreach ($data as $key => $values) {
		if ($key == 'gradeboundary') {
			foreach ($values as $key1 => $value2) {
				$gradeBText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==100)){
					$form->addOption($gradeBText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					$form->addOption($gradeBText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Time Limit (minutes)<font color="red"><strong> *</strong></font>',array('text-align'=>'left','style'=>'width:200px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addInput("text",array('name'=>'timeLimit','value'=>$timeLimit,'tabindex'=>'2','style'=>'width:105px','onkeydown'=>'return ValidateTimeLimit(event);'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	$form->addLabel('Status 2',array('text-align'=>'left'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	if(!empty($STAT)){
		foreach($STAT[1] as $key2=>$value3){
			$stat=$key2;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'status2','id' => 'status2','tabindex'=>'13','style'=>'width:250px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => 1000));
	foreach ($data as $key => $values) {
		if ($key == 'status') {
			foreach ($values as $key1 => $value2) {
				$statusText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==2)){
					$form->addOption($statusText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					if ($optVal!=0) $form->addOption($statusText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	if(!empty($STAT)){
		foreach($STAT[1] as $key2=>$value3){
			$stat=$value3;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'gradeBoundary2','id' => 'gradeBoundary2','tabindex'=>'14','style'=>'width:100px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => -1));
	foreach ($data as $key => $values) {
		if ($key == 'gradeboundary') {
			foreach ($values as $key1 => $value2) {
				$gradeBText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==80)){
					$form->addOption($gradeBText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					$form->addOption($gradeBText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Questions per Page',array('text-align'=>'left','style'=>'width:250px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->openSelect(array('name' => 'questionPerPage','tabindex'=>'3', 'style'=>'width:110px'));
	foreach ($data as $key => $values) {
		if ($key == 'questionperpage') {
			foreach ($values as $key1 => $value2) {
				$QPPText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if ($questionPerPage==$optVal){
					$form->addOption($QPPText, array('value' => $optVal,'selected'=>'selected'));
				}
				else {
					$form->addOption($QPPText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	$form->addLabel('Status 3',array('text-align'=>'left','style'=>'width:100px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	if(!empty($STAT)){
		foreach($STAT[2] as $key2=>$value3){
			$stat=$key2;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'status3','id' => 'status3','tabindex'=>'15','style'=>'width:250px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => 1000));
	foreach ($data as $key => $values) {
		if ($key == 'status') {
			foreach ($values as $key1 => $value2) {
				$statusText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==3)){
					$form->addOption($statusText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					if ($optVal!=0) $form->addOption($statusText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	if(!empty($STAT)){
		foreach($STAT[2] as $key2=>$value3){
			$stat=$value3;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'gradeBoundary3','id' => 'gradeBoundary3','tabindex'=>'16','style'=>'width:100px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => -1));
	foreach ($data as $key => $values) {
		if ($key == 'gradeboundary') {
			foreach ($values as $key1 => $value2) {
				$gradeBText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==60)){
					$form->addOption($gradeBText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					$form->addOption($gradeBText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Shuffle Questions?',array('text-align'=>'left','style'=>'width:250px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	if ($ShuffleQ==1){
		$form->addInput('radio', array('name'=>'ShuffleQ','value'=>1,'id'=>'ShuffleQYes','tabindex'=>'4','checked'=>'checked','style' => 'width: 1em;','onclick'=>'SelectShuffleQY();'));
	    $form->addInline('   Yes     ');
	    $form->addInput('radio', array('name'=>'ShuffleQ','value'=>0,'id'=>'ShuffleQNo','tabindex'=>'5','style' => 'width: 1em;','onclick'=>'SelectShuffleQN();'));
	    $form->addInline('  No'); 
	}
	if ($ShuffleQ==0){
		$form->addInput('radio', array('name'=>'ShuffleQ','value'=>1,'id'=>'ShuffleQYes','tabindex'=>'4','style' => 'width: 1em;','onclick'=>'SelectShuffleQY();'));
	    $form->addInline('   Yes     ');
	    $form->addInput('radio', array('name'=>'ShuffleQ','value'=>0,'id'=>'ShuffleQNo','tabindex'=>'5','checked'=>'checked','style' => 'width: 1em;','onclick'=>'SelectShuffleQN();'));
	    $form->addInline('  No'); 
	}
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	$form->addLabel('Status 4',array('text-align'=>'left','style'=>'width:100px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	if(!empty($STAT)){
		foreach($STAT[3] as $key2=>$value3){
			$stat=$key2;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'status4','id' => 'status4','tabindex'=>'17','style'=>'width:250px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => 1000));
	foreach ($data as $key => $values) {
		if ($key == 'status') {
			foreach ($values as $key1 => $value2) {
				$statusText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==4)){
					$form->addOption($statusText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					if ($optVal!=0) $form->addOption($statusText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	if(!empty($STAT)){
		foreach($STAT[3] as $key2=>$value3){
			$stat=$value3;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'gradeBoundary4','id' => 'gradeBoundary4','tabindex'=>'18','style'=>'width:100px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => -1));
	foreach ($data as $key => $values) {
		if ($key == 'gradeboundary') {
			foreach ($values as $key1 => $value2) {
				$gradeBText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==40)){
					$form->addOption($gradeBText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					$form->addOption($gradeBText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Shuffle within Questions?',array('text-align'=>'left','style'=>'width:250px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	if ($ShuffleWithinQ==1){
		$form->addInput('radio', array('name'=>'ShuffleWithinQ','value'=>1,'id'=>'ShuffleWQYes','tabindex'=>'6','checked'=>'checked','style' => 'width: 1em;','onclick'=>'SelectShuffleWQY();'));
    	$form->addInline('   Yes     ');
    	$form->addInput('radio', array('name'=>'ShuffleWithinQ','value'=>0,'tabindex'=>'7','id'=>'ShuffleWQNo','style' => 'width: 1em;','onclick'=>'SelectShuffleWQN();'));
    	$form->addInline('  No');
	} 
	if ($ShuffleWithinQ==0){
		$form->addInput('radio', array('name'=>'ShuffleWithinQ','value'=>1,'id'=>'ShuffleWQYes','tabindex'=>'6','style' => 'width: 1em;','onclick'=>'SelectShuffleWQY();'));
    	$form->addInline('   Yes     ');
    	$form->addInput('radio', array('name'=>'ShuffleWithinQ','value'=>0,'checked'=>'checked','tabindex'=>'7','id'=>'ShuffleWQNo','style' => 'width: 1em;','onclick'=>'SelectShuffleWQN();'));
    	$form->addInline('  No');
	}
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	$form->addLabel('Status 5',array('text-align'=>'left','style'=>'width:100px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	if(!empty($STAT)){
		foreach($STAT[4] as $key2=>$value3){
			$stat=$key2;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'status5','id' => 'status5','tabindex'=>'19','style'=>'width:250px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => 1000));
	foreach ($data as $key => $values) {
		if ($key == 'status') {
			foreach ($values as $key1 => $value2) {
				$statusText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==5)){
					$form->addOption($statusText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					if ($optVal!=0) $form->addOption($statusText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	if(!empty($STAT)){
		foreach($STAT[4] as $key2=>$value3){
			$stat=$value3;
		}
	}
	else {
		$stat='';
	}
	$form->openSelect(array('name' => 'gradeBoundary5','id' => 'gradeBoundary5','tabindex'=>'20','style'=>'width:100px','onchange'=>'ValidateInput(this);'));
	$form->addOption('Not Required', array('value' => -1));
	foreach ($data as $key => $values) {
		if ($key == 'gradeboundary') {
			foreach ($values as $key1 => $value2) {
				$gradeBText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$stat)||($optVal==20)){
					$form->addOption($gradeBText, array('value' => $optVal,'selected'=>'selected'));
				}
				else{
					$form->addOption($gradeBText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Attempts Allowed',array('text-align'=>'left','style'=>'width:250px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->openSelect(array('name' => 'attemptsAllowed','tabindex'=>'8', 'style'=>'width:110px'));
	foreach ($data as $key => $values) {
		if ($key == 'attemptsallowed') {
			foreach ($values as $key1 => $value2) {
				$attallowedText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if($attemptsAllowed==$optVal){
					$form->addOption($attallowedText, array('value' => $optVal,'selected'=>'selected'));
				}
				else {
					$form->addOption($attallowedText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:30px;'));
	$form->addLabel('Required grade for completing module',array('text-align'=>'left','style'=>'width:220px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->openSelect(array('name' => 'reqGrade','id' => 'reqGrade','tabindex'=>'21', 'style'=>'width:110px'));
	foreach ($data as $key => $values) {
		if ($key == 'gradeboundary') {
			foreach ($values as $key1 => $value2) {
				$gradeBText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if (($optVal==$reqGrade)||($optVal==40)){
					$form->addOption($gradeBText, array('value' => $optVal,'selected'=>'selected'));
				}
				else {
					$form->addOption($gradeBText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Grading Method',array('text-align'=>'left','style'=>'width:250px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->openSelect(array('name' => 'gradingMethod','tabindex'=>'9', 'style'=>'width:110px'));
	foreach ($data as $key => $values) {
		if ($key == 'gradingmethod') {
			foreach ($values as $key1 => $value2) {
				$gradingMethodText=$value2['meta_text'];
				$optVal=$value2['meta_code'];
				if($gradingMethod==$optVal){
					$form->addOption($gradingMethodText, array('value' => $optVal,'selected'=>'selected'));
				}
				else {
					$form->addOption($gradingMethodText, array('value' => $optVal));
				}
			}
		}
	}
	$form->closeSelect();
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addLabel('Is Active',array('text-align'=>'left'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%'));
	$form->addInput("checkbox",array('name'=>'IsActive','tabindex'=>'10','id'=>'IsActiveID','style' => 'width: 1em; height:1em','checked'=>'checked','onClick'=>'ConfirmInActive();'));
	$form->closeTableColumn();
	
	$form->closeTableRow();
	
	$form->closeTableBody();
	$form->closeTable();
	$form->addInline('</div>');
	
	$form->addInline('</br><p align="center">');
	$form->addInput('submit', array('name' => 'submit', 'value' => 'Save & Proceed','tabindex'=>'21'));
	$form->addInline('&nbsp;');
	$form->addInput('submit', array('name' => 'return', 'value' => 'Save & Return','tabindex'=>'22'));
	$form->addInline('&nbsp;');
	$form->addInput('submit', array('name' => 'back', 'value' => 'Back','tabindex'=>'23'));
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
       
