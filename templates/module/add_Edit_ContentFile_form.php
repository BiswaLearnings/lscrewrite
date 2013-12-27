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
// @date 2013-04-04                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////

//ob_start();
//TO DO
?>
<?php 
include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/libs/form_handler.php';

$knode=array();
$account=array();
$modules=array();
?>
<script type="text/javascript">
function SelectFile(){
	File=document.getElementById("File").checked;
	if(File){
		document.getElementById("Link").checked=false;
		document.getElementById("URLTR").style.display = 'none';
		document.getElementById("LinkSkillPort").style.display = 'none';
		document.getElementById("FileUpload").style.display = '';
	}
}
function SelectLink(){
	Link=document.getElementById("Link").checked;
	if(Link){
		document.getElementById("File").checked=false;
		document.getElementById("URLTR").style.display = '';
		document.getElementById("LinkSkillPort").style.display = '';
		document.getElementById("FileUpload").style.display = 'none';
	}
}
function ConfirmInActive(){
	if (document.getElementById("IsActiveID").checked==false) {
		if (confirm('Are you sure to wish to make the Content inactive ?'))
		{
			document.getElementById("IsActiveID").checked=false;
		}
		else {
			document.getElementById("IsActiveID").checked=true;
		}
	}
}

function DisplayForm(){
	document.getElementById("InputTableBody").style.display='';
}
function HideForm(){
	document.getElementById("InputTableBody").style.display='none';
}
function Display(alertMsg){
	alert(alertMsg);
	return;
}

</script>

<?php
	$moduleText='';$SaveStatus=5;$EditStatus=0;$contentID='';
	foreach($data as $key=>$val ){
		if($key=='message'){
           $message=$val;
        }
		if($key=='HeaderForContent'){
			$HeaderForContent=$val;
		}
		if($key=='contentDetails'){
			foreach ($val as $key1 => $value1) {
				$contentName=$value1['content_name'];
				$contentType=$value1['content_type'];
				$url=$value1['url'];
				$skillport=$value1['skillport_requried'];
				$contentFile=$value1['file_name'];
				$isActive=$value1['is_active'];
	        }
		}
		if($key=='SaveStatus'){
			$SaveStatus=$val['Flag'];
		}
		if($key=='EditStatus'){
			$EditStatus=$val['Flag'];
		}
		if($key=='ContentID'){
			$contentID=$val['ContentID'];
		}
	}
	$moduleID = $HeaderForContent[0];
	$moduleName = $HeaderForContent[1];
	$param="$moduleID,$moduleName,$contentID";
	$moduleText=$moduleName;
	//
	$form = new lscform();
	$form->openForm(array('action' => '?load=module/saveContentFile/'.$param.'', 'name' => 'addContentFileForm'));
	$form->openTable(array('name' => 'add_content_Button_table', 'id'=>'buttontable','cellpadding' => "0", 'cellspacing' => "10", 'border' => "0",'width'=>'100%'));
	$form->openTableBody();
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'70%'));
	$form->addInline('<div style="color: green;font: bold 12px arial,sans-serif;padding-left:20px;"><b>'.$moduleText.'</b></div>');	
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'10%'));
	$form->addInput('button', array('name' => 'addContentFile', 'value' => 'Add Content File', 'style' => 'height:20px;width:120px;font: bold 10px arial,sans-serif;','onclick'=>'DisplayForm();'));
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->closeTableBody();
	$form->closeTable();
	$form->addInline('<div class="mcright" id="InputTableBody" style="position:relative; left:2%; top:5px; width:95%; height:160px; z-index:2; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;overflow-y:auto">');
	$form->openTable(array('name' => 'add_module_table_details', 'id'=>'ListPromptHeader','cellpadding' => "0", 'cellspacing' => "0", 'border' => "0",'width'=>'50%','style'=>'position:relative; left:20%;'));
	$form->openTableBody();
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'30%','style'=>'padding-left:50px;'));
	$form->addLabel('Content Name <font color="red">*</font>',array('text-align'=>'right','style'=>'width:150px;'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'20%','style'=>'padding-left:20px;'));
	$form->addInput('text',array('name'=>'contentName','id'=>'contentNameID','value'=>$contentName,'style' => 'width: 25em;'));
	$form->closeTableColumn();
	$form->closeTableRow();
	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:50px;'));
	$form->addLabel('Content Type',array('text-align'=>'left','style'=>'width:150px'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:20px;'));
	if ($contentType==1){
		$form->addInput('radio', array('name'=>'contentType','value'=>1,'id'=>'File','checked'=>'checked','style' => 'width: 1em;','onclick'=>'SelectFile();'));
	    $form->addInline('   File     ');
	    $form->addInput('radio', array('name'=>'contentType','value'=>0,'id'=>'Link','style' => 'width: 1em;','onclick'=>'SelectLink();'));
	    $form->addInline('  Link');
	} 
	if ($contentType==0){
		$form->addInput('radio', array('name'=>'contentType','value'=>1,'id'=>'File','style' => 'width: 1em;','onclick'=>'SelectFile();'));
	    $form->addInline('   File     ');
	    $form->addInput('radio', array('name'=>'contentType','value'=>0,'id'=>'Link','checked'=>'checked','style' => 'width: 1em;','onclick'=>'SelectLink();'));
	    $form->addInline('  Link');
	}
    $form->addLabel('Is Active?',array('text-align'=>'left','style'=>'width:70px;padding-left:100px;'));
    $form->addInput("checkbox",array('name'=>'IsActive','tabindex'=>'10','id'=>'IsActiveID','style' => 'width: 1em; height:1em','checked'=>'checked','onClick'=>'ConfirmInActive();'));
    $form->closeTableColumn();
	$form->closeTableRow();
	if ($contentType==0){
		$form->openTableRow(array('id'=>'URLTR'));
		$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:50px;'));
		$form->addLabel('URL <font color="red">*</font>',array('text-align'=>'right','style'=>'width:150px;'));
		$form->closeTableColumn();
		$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:20px;'));
		$form->addInput('text',array('name'=>'url','id'=>'URL','value'=>$url,'style' => 'width: 25em;'));
		$form->closeTableColumn();
		$form->closeTableRow();
		$form->openTableRow(array('id'=>'LinkSkillPort'));
		$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:50px;'));
		$form->addLabel('Is this a link to Skillport?',array('text-align'=>'left','style'=>'width:150px'));
		$form->closeTableColumn();
		$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:20px;'));
		if ($skillport==0){
			$form->addInput('radio', array('name'=>'skillport','value'=>1,'style' => 'width: 1em;'));
		    $form->addInline('   Yes     ');
		    $form->addInput('radio', array('name'=>'skillport','value'=>0,'checked'=>'checked','style' => 'width: 1em;'));
		    $form->addInline('  No');
		}
		if ($skillport==1){
			$form->addInput('radio', array('name'=>'skillport','value'=>1,'checked'=>'checked','style' => 'width: 1em;'));
		    $form->addInline('   Yes     ');
		    $form->addInput('radio', array('name'=>'skillport','value'=>0,'style' => 'width: 1em;'));
		    $form->addInline('  No');
		}
		$form->closeTableColumn();
		$form->closeTableRow();
	}
	if ($contentType==1){	
		$form->openTableRow(array('id'=>'FileUpload'));
		$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:50px;'));
		$form->addLabel('Upload File <font color="red">*</font>',array('text-align'=>'left','style'=>'width:150px'));
		$form->closeTableColumn();
		$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:20px;'));
		$form->addInput('file', array('name'=>'contentFile','style' => 'width: 29em;')); 
		$form->closeTableColumn();
		$form->closeTableRow();
	}	
	$form->openTableRow();
	$form->openTableColumn(array('width'=>'10%'));
	$form->closeTableColumn();
	$form->openTableColumn(array('width'=>'10%','style'=>'padding-left:30px;'));
	$form->addInput('submit', array('name' => 'submit', 'value' => 'Save'));
	$form->addInput('button', array('name' => 'cancel', 'value' => 'Cancel','onclick'=>'HideForm();'));
	$form->closeTableColumn();
	$form->closeTableRow();
	$form->closeTableBody();
	$form->closeTable();
	$form->addInline('</div>');
	$form->closeForm();
	echo $form;  
	//
    $form1 = new lscform();
    $form1->addInline('<div id="TableContent" style="position:relative;left:2%;top:10px; width:95%;>');
	$form1->openForm(array('action' => '?load=module/addContentFile/'.$param.'', 'name' => 'addEditContentFileForm'));
	//Form Start
	$form1->addInline('<div class="jquery-table" >');
	$form1->openTable(array('name' => 'view_module_table', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "1", 'class' => "display", 'id' => "example"));
	$form1->openTableHeader();
	$form1->openTableRow();
	$form1->addTableHead($lang['content_names']);
	$form1->addTableHead($lang['content_types'],array('style'=>'width:100px'));
	$form1->addTableHead($lang['file_link'],array('colspan'=>3));
	$form1->closeTableRow();
	$form1->closeTableHeader();
	$form1->openTableBody();
	if (!empty($data)) {	
		foreach($data as $key => $value){
			if($key=='TableDetails'){
				$modulea=$value;
			}
		}
	}
	foreach ($modulea as $key=>$val) {
		$form1->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
		$form1->addTableColumn($val['content_name']);
		if ($val['content_type']==0) {
			$form1->addTableColumn('<div align="center">Link</div>');
			$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/link1.png" width="15px"/>&nbsp;<a href="javascript:;" onclick=redirectToURL('.'"'.$val['url'].'"'.')><u>'.$val['url'].'</u></a>');
		}
		if ($val['content_type']==1) {
			$form1->addTableColumn('<div align="center">File</div>');
			$fileType=$val['file_type'];
			$mimeType=$lang[$fileType];
			$ContId=$val['id'];
			$fileParam="$ContId/$mimeType";
			if (($val['file_type']=='docx')||($val['file_type']=='doc')){
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/word.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
			else if (($val['file_type']=='xls')||($val['file_type']=='xlsx')){
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/excel.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
			else if ($val['file_type']=='pdf'){
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/pdf.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
			else if ($val['file_type']=='txt'){
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/text.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
			else if ($val['file_type']=='zip'){
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/zip.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
			else if ($val['file_type']=='rar'){
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/rar.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
			else if (($val['file_type']=='jpg')||($val['file_type']=='png')||($val['file_type']=='bmp')){
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/image.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
			else {
				$form1->addTableColumn('<img src="'.WEB_PATH.'/content/images/CommonImages/unknown.png" width="15px"/>&nbsp;<a href="javascript:;" onclick="redirectToURL(\''.WEB_PATH.'/?load=module/ShowFileContent/'.$fileParam.'\');"><u>'.$val['file_name'].'</u></a>');
			}
		}
		$contentID=$val['id'];
		$param1="$moduleID,$moduleName,$contentID";
		$form1->addTableColumn('<div align="center"><a href="?load=module/EditContentFile/'.$param1.'"><u>Edit</u></a></div>');
		$form1->addTableColumn('<div align="center"><a href="?load=module/DeleteContentFile/'.$param1.'"onclick="return confirm(\'Are you sure to wish to delete?\')"><u>Delete</u></a></div>');
		//
		$form1->closeTableRow();
	}
	$form1->closeTableBody();
	$form1->closeTable();
	$form1->addInline('</div>');
	$form1->addInline('<p align="center">');
	$form1->addInput('submit', array('name' => 'back', 'value' => 'Back'));
	$form1->addInline('</p>');
	$form1->addInline('</div>');
	$form1->closeForm();
	echo $form1;
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
	//echo "Save Status : ".$SaveStatus;
	if ($SaveStatus==0){
		if (($alertMessage=='') && ($SaveStatus!='New')){
			echo "<script>alert('There are some error occurs while saving.');</script>";
			echo "<script>DisplayForm();</script>";
		}
		else if (($SaveStatus==5) or ($EditStatus==1)){
			echo "<script>DisplayForm();</script>";
		}
		else {
			echo "<script>HideForm();</script>";
		}
	}
	else {
		echo "<script>HideForm();</script>";
	
	}
?>

