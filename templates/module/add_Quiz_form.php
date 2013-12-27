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
// @date 2012-4-4                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////

//ob_start();
//TO DO

include_once __SITE_PATH . '/lang/lang.php';
require_once __SITE_PATH . '/libs/form_handler.php';

?>
<?php 
	$moduleText='';
	foreach($data as $key=>$val ){
		if($key=='HeaderForQuiz'){
			$HeaderForQuiz=$val;
		}
	}
	$moduleID = $HeaderForQuiz[0];
	$moduleName = $HeaderForQuiz[1];
	$quizID = $HeaderForQuiz[2];
	$param="$quizID,$moduleID,$moduleName";
	$moduleText=$moduleName;
	//
	$form = new lscform();
	$form->openForm(array('action' => '?load=module/UploadQuestion/'.$param.'', 'name' => 'UploadQuizForm'));
	if ($moduleText!='') {
		$form->addInline('<div style="color: green;font: bold 12px arial,sans-serif;padding-left:20px;"><b>'.$moduleText.'</b></div>');
	}
	$form->addInline('<div class="mcright" id="InputTableBody" style="position:relative; left:5%; top:0px; width:90%; height:33px; z-index:2; border-style: solid; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;overflow-y:auto">');
	$form->openTable(array('name' => 'Uplaod_Question_table', 'id'=>'ListPromptHeader','cellpadding' => "0", 'cellspacing' => "0", 'border' => "0",'width'=>'75%'));
	$form->openTableBody();
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:100px;'));
	$form->addLabel('Upload Quiz File <font color="red">*</font>',array('text-align'=>'left','style'=>'width:150px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:20px;'));
	$form->addInput('file', array('name'=>'importFile','value' => 'importFile','style' => 'width: 33em;')); 
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:20px;'));
	$form->addInput('submit', array('name' => 'upload', 'value' => 'Upload','tabindex'=>'20'));
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->closeTableBody();
	$form->closeTable();
	$form->addInline('</div>');
	//
	$form->addInline('<div class="jquery-table">');
	$form->openTable(array('name' => 'view_Question_table', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
	$form->openTableHeader();
	$form->openTableRow();
	$form->addTableHead($lang[serial],array('width'=>'8%'));
	$form->addTableHead($lang[question_type],array('width'=>'12%'));
	$form->addTableHead($lang[question]);
	$form->closeTableRow();
	$form->closeTableHeader();
	$form->openTableBody();
	
	if (!empty($data)) {	
		foreach($data as $key => $value){
			if($key=='QuestionDetails'){
				$QuestionArray=$value;
			}
			if($key=='QuestionType'){
				$QuestionType=$value;
			}
		}
	}
	foreach ($QuestionArray as $key=>$val) {
		$form->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
		$serialNo=(int)$val['serial'];
		$form->addTableColumn('<div align="center">'.$serialNo.'</div>');
		foreach($QuestionType as $key1=>$val1){
			if ($val['question_type']==$val1['meta_code']){
				$questiontype_text=$val1['meta_text'];
			}
		}
		$form->addTableColumn($questiontype_text);
		$newtext = wordwrap($val['question_text'], 150, "<br />\n");
		$form->addTableColumn($newtext);
		$form->closeTableRow();
	}
	$form->closeTableBody();
	$form->closeTable();
	$form->addInline('</div>');  
	//
	$form->addInline('<p align="center">');
	$form->addInput('submit', array('name' => 'submit', 'value' => 'Proceed','tabindex'=>'21'));
	$form->addInline('&nbsp;');
	$form->addInput('submit', array('name' => 'back', 'value' => 'Back','tabindex'=>'23'));
	$form->addInline('</p>');
	$form->closeForm();
	echo $form;    
?>