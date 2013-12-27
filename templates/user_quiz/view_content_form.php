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
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/form_handler.php';
$form = new lscform();
$form->openForm(array('method' => 'POST', 'action' => '?load=userQuiz/showSkillportCertificateUpload/'.$data["module_Id"], 'id' => 'viewContent', 'name' => 'viewContent'));

$form->addInline('<div class="jquery-table" >');
$form->openTable(array('name'=>'viewContent','cellspacing'=>'0','border'=>'0','class'=>'display','id'=>'example'));
$form->openTableHeader();
$form->openTableRow();
$form->addTableHead($lang['content_names']);
$form->addTableHead($lang['file_link']);
$form->closeTableRow();

$form->closeTableHeader();
$form->openTableBody();

if (!empty($data['content_details'])) {
    foreach($data['content_details'] as $key => $content) {
		$contentId=$content['content_id'];   
		
		$form->openTableRow(array('class'=>'odd_gradeX','id'=>'2'));   
		$form->openTableColumn(array('style'=>'width:40%'));
		$form->addInline('<b>'.$content["content_name"].'</b>');
		$form->closeTableColumn();
		
		$form->openTableColumn();
    	if ($content['content_type']==0) {
			$img = '<img src="'.WEB_PATH.'/content/images/CommonImages/link1.png" width="15px"/>';
			$form->addInline($img.'&nbsp;<a href="?load=account/showEditAccount/'.$contentId.'"><u>'.$content["url"].'</u></a>');
		}
		$form->addInline('<a href="?load=account/showEditAccount/'.$contentId.'"><u>'.$content["file_name"].'</u></a>');
		$form->closeTableColumn();
		
		$form->closeTableRow();
     }
}
$form->closeTableBody();
$form->closeTable();
$form->addInline('</div>');
$form->addInline('<p align = "right" style="padding-right:20px">');
$form->addInput('submit', array('name'=>'proceed','value'=>'Proceed to attempt quiz'));
$form->addInline('</p>');
$form->closeForm();
echo $form;
?>
                
            
