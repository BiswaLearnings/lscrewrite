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
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/libs/form_handler.php';

$knode=array();
$account=array();
$modules=array();
?>

<script type="text/javascript">
	function ValidateKNode()
	{
		var knowledge=document.getElementById("knowledgenodeID");
		var inputVal=knowledge.value;
		if (inputVal=='0' || inputVal==1){
			document.getElementById("accountID").selectedIndex=0;
			makeDisable();
		}
		else {
			makeEnable();
			document.getElementById("accountID").selectedIndex=0;
		}	
	}
	function makeDisable(){
	    var x=document.getElementById("accountID");
	    x.disabled=true;
	}
	function makeEnable(){
	    var x=document.getElementById("accountID");
	    x.disabled=false;
	}
	function CheckReqInput(){
		var e = document.getElementById("knowledgenodeID");
		var str = e.options[e.selectedIndex].value;
		if (str==0){
			alert("Please select a Knowledge Node");
			return;
		}
		else {
			//MakeVisible();
		}
	}
	function ValidateAccount(knodeValue, accountValue){
		if (knodeValue==0){
			alert("Please select a Knowledge Node");
			document.getElementById("accountID").value=0;
			return;
		}
		else if (knodeValue==1) {
			alert("Please select a valid Knowledge Node");
			document.getElementById("accountID").value=0;
			return;
		}
	}
	
</script>
<?php
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
	$accountText='';
	$knodeText='';
	if (isset($data['combos'])){
		$knodeRET=$data['combos'][0]; 
		$accountRET=$data['combos'][1];
		foreach($knode as $key=>$val ){
			if ($knodeRET==$val['meta_code']) {
				$knodeText=$val['meta_text'];
			}
		}
		foreach($account as $key=>$val ){
			if ($accountRET==$val['id']) {
				$accountText=$val['account_name'];
			}
		}
	}
	else {
		$knodeRET='';
		$accountRET='';
	}
    $form = new lscform();
	$form->openForm(array('action' => '?load=module/showModules/', 'name' => 'viewModuleForm1'));
	$form->addInline('<p align="center">');
	$form->addLabel('Knowledge Node',array('text-align'=>'left','style'=>'width:100px;'));
	$form->openSelect(array('name'=>'knowledgenode','id'=>'knowledgenodeID','width'=>'200px','style'=>'font:12px arial,sans-serif','onchange'=>'ValidateKNode()'));
	$form->addOption('Select a Knowledge Node',array('value'=>'0','selected'=>'selected'));
	foreach($knode as $key=>$val ){
		if ($knodeRET==$val['meta_code']){
			$form->addOption($val['meta_text'],array('value'=>$val['meta_code'],'selected'=>'selected'));
		}
		else {
			$form->addOption($val['meta_text'],array('value'=>$val['meta_code']));
		}
	}                           
	$form->closeSelect();
	for ($i=0;$i<10;$i++){
		$form->addInline('&nbsp');	
	}
	$form->addLabel('Account',array('text-align'=>'left','style'=>'width:60px;'));
	$form->openSelect(array('name'=>'account','id'=>'accountID','width'=>'200px','style'=>'font:12px arial,sans-serif','onchange'=>'ValidateAccount(knowledgenode.value,this.value)'));
	$form->addOption('Select an account',array('value'=>'0','selected'=>'selected'));
	foreach($account as $key=>$val ){
		if ($accountRET==$val['id']){
			$form->addOption($val['account_name'],array('value'=>$val['id'],'selected'=>'selected'));
		}
		else {
			$form->addOption($val['account_name'],array('value'=>$val['id']));
		}
	}
	$form->closeSelect();
	//$form->addInline('&#30;&nbsp;');
	for ($i=0;$i<10;$i++){
		$form->addInline('&nbsp');	
	}
	$form->addInput('submit', array('name' => 'submit','value' => 'Show Modules ','alt'=>'Click to view modules', 'onclick'=>'CheckReqInput();'));
	for ($i=0;$i<3;$i++){
		$form->addInline('&nbsp');	
	}
	$form->addInput('submit', array('name' => 'addModule', 'value' => 'Add Module ','onclick'=>'CheckReqInput();'));
	$form->addInline('</p>');
	$form->closeForm();
	echo $form;
	//
	//Displaying Knowledge Node Inforamtion
	if ($knodeRET==0 || $knodeRET==1){
		echo '<script type="text/javascript">ValidateKNode();</script>';
	} 
	$textH='';	//newly added :29/03/2013
	if ($knodeText!='') {
		$form1 = new lscform();
		$form1->openForm(array('action' => '*', 'name' => 'viewHeaderInfo'));
		$textH='<div style="color: green;font: bold 12px arial,sans-serif;"><b>'.$knodeText.'</b>';
	}
	if ($accountText!='') {
		$textH.='<b> : </b>';
		$textH.='<b>'.$accountText.'</b>';
	}
	if ($textH!="") {
		$textH.='</div>';
		$form1->addInline(''.$textH.'');
		$form1->closeForm();
		echo $form1;  
	}
     //
	$form2 = new lscform();
	//Form Start
	$form2->openForm(array('method' => 'POST', 'action' => '', 'id' => 'viewModule', 'name' => 'viewModule'));
    $form2->addInline('<div class="jquery-table" >');
	$form2->openTable(array('name' => 'view_module_table', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
	$form2->openTableHeader();
	$form2->openTableRow();
	$form2->addTableHead($lang[modulename],array('colspan'=>7));
	$form2->closeTableRow();
	$form2->closeTableHeader();
	$form2->openTableBody();
	
	$show=0;
	if (!empty($data)) {	
		foreach($data as $key => $value){
			if($key=='module'){
				$modulea=$value;
				$show=1;
			}
		}
	}

	foreach ($modulea as $key=>$val) {
		$form2->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
		$param = "$val[id],$val[module_name]";
		$form2->addTableColumn($val[module_name]);
		$form2->addTableColumn('<a href="?load=module/editModules/'.$val[id].'"><u>Edit</u></a>');
		$form2->addTableColumn('<a href="?load=module/addEditAssessment/'.$param.'"><u>Add / Edit Assessment</u></a>');
		$form2->addTableColumn('<a href="?load=module/addEditContentFile/'.$param.'"><u>Add / Edit Content File</u></a>');
		$form2->addTableColumn('<a href="?load=userQuiz/showConfidential/'.$val[id].'><u>Preview</u></a>');
		$form2->addTableColumn('<a href="*"><u>Result</u></a>');
		$form2->addTableColumn('<a href="*"><u>Grade</u></a>');
		$form2->closeTableRow();
	}
	$form2->closeTableBody();
	$form2->closeTable();
	$form2->addInline('</div></div>');
	$form2->closeForm();
	echo $form2;      
?>


